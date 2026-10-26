<?php

namespace App\Imports;

use App\Models\PlotAndUnit;
use App\Models\PlotType;
use App\Models\Road;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MembersImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected string $jobId;
    protected array $roadCache = [];
    protected array $plotTypeCache = [];
    protected array $existingKeys = [];
    protected array $usedUniqueIds = [];

    public function __construct(string $jobId)
    {
        $this->jobId = $jobId;

        // 1. Existing roads cache kora
        Road::all(['id', 'number'])->each(function ($r) {
            $cleaned = (string) preg_replace('/[^0-9]/', '', $r->number);
            $this->roadCache[$cleaned] = $r->id;
            $this->roadCache[strtolower(trim($r->number))] = $r->id;
        });

        // 2. Existing plot types cache kora
        PlotType::all(['id', 'name'])->each(function ($pt) {
            $this->plotTypeCache[strtolower(trim($pt->name))] = $pt->id;
        });

        // 3. Database-er existing records memory-te load kora jate duplicate skip hoy
        PlotAndUnit::query()
            ->select(['road_id', 'holding_no', 'flat_no', 'name'])
            ->get()
            ->each(function ($item) {
                $hashKey = $this->makeDuplicateKey($item->road_id, $item->holding_no, $item->flat_no, $item->name);
                $this->existingKeys[$hashKey] = true;
            });
    }

    /**
     * Smart Duplicate Key Generator
     * Flat no missing thakle contact name ba plot type diye track korbe
     */
    protected function makeDuplicateKey($roadId, $holdingNo, ?string $flatNo, ?string $contactName = null, ?string $plotType = null): string
    {
        $cleanHolding = strtolower(trim((string)$holdingNo));
        $cleanFlat    = strtolower(trim((string)$flatNo));
        $cleanName    = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string)$contactName));

        // 1. Flat no thakle flat diye check
        if (!empty($cleanFlat)) {
            return "{$roadId}_{$cleanHolding}_flat_{$cleanFlat}";
        }

        // 2. Flat no na thakle name diye check (ekoi holding-e alada manush skip hobe na)
        if (!empty($cleanName)) {
            return "{$roadId}_{$cleanHolding}_name_{$cleanName}";
        }

        // 3. Flat ebong name duto-i missing thakle plot type diye unique dhore
        $cleanType = strtolower(trim((string)$plotType));
        return "{$roadId}_{$cleanHolding}_main_{$cleanType}";
    }

    public function collection(Collection $rows)
    {
        $progress = Cache::get("import_progress_{$this->jobId}", [
            'total'      => 0,
            'processed'  => 0,
            'success'    => 0,
            'skipped'    => 0,
            'errors'     => [],
            'status'     => 'processing',
            'percentage' => 0,
        ]);

        $records = [];
        $now = now();

        foreach ($rows as $row) {
            $progress['processed']++;

            $holdingNo   = trim((string)($row['holding_no'] ?? $row['holding'] ?? ''));
            $contactName = trim((string)($row['contact_person_name'] ?? $row['name'] ?? ''));

            // Row faka kina check
            if ($holdingNo === '' && $contactName === '') {
                $progress['skipped']++;
                continue;
            }

            // Road ID resolve kora
            $rawRoad = (string)($row['road'] ?? '');
            $roadNumberClean = (string) preg_replace('/[^0-9]/', '', $rawRoad);
            $roadId = $this->resolveRoadId($rawRoad, $roadNumberClean);

            $flatNo      = !empty($row['person_flat_no']) ? trim((string)$row['person_flat_no']) : null;
            $rawPlotType = trim((string)($row['plot_type'] ?? ''));

            // ========================================================
            // SMART DUPLICATE CHECK
            // ========================================================
            $rowKey = $this->makeDuplicateKey($roadId, $holdingNo, $flatNo, $contactName, $rawPlotType);

            if (isset($this->existingKeys[$rowKey])) {
                // DB ba sheet-er ager row-te already thakle skip hobe
                $progress['skipped']++;
                continue;
            }

            // Sheet-er porer row-te same data asle jate duplicate dhora pore
            $this->existingKeys[$rowKey] = true;

            try {
                $plotTypeId = $this->resolvePlotTypeId($rawPlotType);

                // Phone number format kora (faka thakle faka-i thakbe, kono dummy 01000000 hobe na)
                $rawPhone = (string)($row['person_phone'] ?? $row['phone'] ?? '');
                $phone    = $this->formatPhoneNumber($rawPhone);
                $email     = !empty($row['person_email']) ? substr(trim((string)$row['person_email']), 0, 254) : null;
                $uniqueId = substr($this->generateUniqueId($roadNumberClean ?: '0', $holdingNo, $flatNo, $rawPlotType), 0, 30);

                // Create or sync the member account using the imported contact details.
                // Rows without a phone number cannot be uniquely matched to a user.
                if ($phone !== '') {
                    User::updateOrCreate(
                        ['phone' => $phone],
                        [
                            'uid'     => $uniqueId,
                            'role'     => 'member',
                            'name'     => $contactName,
                            'email'    => $email,
                            'password' => Hash::make(Str::random(10)),
                            'phone'    => $phone,
                        ]
                    );
                }

                $totalFlat     = isset($row['total_flat']) && is_numeric($row['total_flat']) ? (int)$row['total_flat'] : 0;
                $occupiedFlat  = isset($row['occupied_flat']) && is_numeric($row['occupied_flat']) ? (int)$row['occupied_flat'] : 0;
                $flatNumbers   = !empty($row['flat_numbers']) ? trim((string)$row['flat_numbers']) : null;

                $collectionType = !empty($row['collection_type']) ? trim((string)$row['collection_type']) : null;
                if ($collectionType && !in_array($collectionType, ['Group', 'Individual'])) {
                    $collectionType = strtolower($collectionType) === 'group' ? 'Group' : 'Individual';
                }

                $collectionRate = isset($row['collection_rate']) && is_numeric($row['collection_rate']) ? (float)$row['collection_rate'] : 0.00;
                $discount       = isset($row['discount']) && is_numeric($row['discount']) ? (float)$row['discount'] : 0.00;
                $totalAmount    = isset($row['collection_amount']) && is_numeric($row['collection_amount'])
                    ? (float)$row['collection_amount']
                    : ($collectionRate * max(1, $occupiedFlat));

                $status   = (strtolower($rawPlotType) === 'empty plot') ? 'Hold' : 'Active';

                $records[] = [
                    'road_id'         => $roadId,
                    'plot_type_id'    => $plotTypeId,
                    'unique_id'       => $uniqueId,
                    'holding_no'      => substr($holdingNo, 0, 20),
                    'building_name'   => !empty($row['building_name']) ? substr(trim((string)$row['building_name']), 0, 100) : null,
                    'name'            => substr($contactName ?: ($flatNo ? "Resident {$flatNo}" : "Holding {$holdingNo}"), 0, 100),
                    'flat_no'         => $flatNo ? substr($flatNo, 0, 30) : null,
                    'phone'           => $phone ?? '',
                    'email'           => $email,
                    'total_flat'      => $totalFlat,
                    'occupied_flat'   => $occupiedFlat,
                    'flat_numbers'    => $flatNumbers,
                    'collection_type' => $collectionType,
                    'collection_rate' => $collectionRate,
                    'discount'        => $discount,
                    'total_amount'    => $totalAmount,
                    'status'          => $status,
                    'import_batch_id' => $this->jobId,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];

                $progress['success']++;
            } catch (\Exception $e) {
                $progress['skipped']++;
                if (count($progress['errors']) < 25) {
                    $progress['errors'][] = "Row {$progress['processed']} (Holding: {$holdingNo}): " . $e->getMessage();
                }
            }
        }

        if (!empty($records)) {
            DB::table('plot_and_units')->insert($records);
        }

        // Live progress percentage calculation
        $total = $progress['total'] ?: 1;
        $progress['percentage'] = min(99, round(($progress['processed'] / $total) * 100));

        Cache::put("import_progress_{$this->jobId}", $progress, 600);
    }

    public function chunkSize(): int
    {
        return 300;
    }

    protected function resolveRoadId(string $rawRoad, string $roadNumberClean): int
    {
        if (isset($this->roadCache[$roadNumberClean])) {
            return $this->roadCache[$roadNumberClean];
        }

        $key = strtolower(trim($rawRoad));
        if (isset($this->roadCache[$key])) {
            return $this->roadCache[$key];
        }

        $roadNum = $roadNumberClean ?: ($rawRoad ?: '1');
        $road = Road::firstOrCreate(['number' => $roadNum]);
        $this->roadCache[$roadNumberClean] = $road->id;
        $this->roadCache[$key] = $road->id;

        return $road->id;
    }

    protected function resolvePlotTypeId(string $rawPlotType): int
    {
        $rawClean = trim($rawPlotType);
        $key = strtolower($rawClean);

        if (isset($this->plotTypeCache[$key])) {
            return $this->plotTypeCache[$key];
        }

        // Mapping rules
        if (str_contains($key, 'commercial building') || $key === 'commercial') {
            $name = 'Commercial';
        } elseif (str_contains($key, 'owner made building') || $key === 'owner') {
            $name = 'Owner';
        } elseif (str_contains($key, 'empty')) {
            $name = 'Empty Plot';
        } elseif (str_contains($key, 'construction')) {
            $name = 'Under Construction';
        } elseif (str_contains($key, 'apartment')) {
            $name = 'Apartment';
        } else {
            $name = $rawClean ?: 'Apartment';
        }

        $slug = Str::slug($name);

        $plotType = PlotType::firstOrCreate(
            ['name' => $name],
            ['slug' => $slug, 'status' => 'Active']
        );

        $this->plotTypeCache[$key] = $plotType->id;
        $this->plotTypeCache[strtolower($name)] = $plotType->id;

        return $plotType->id;
    }

    protected function formatPhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return '';
        }

        $clean = preg_replace('/[^0-9]/', '', (string)$phone);

        if (empty($clean)) {
            return '';
        }

        // Float / Excel theke asha 10 digit hole leading 0 boshano
        if (strlen($clean) === 10 && str_starts_with($clean, '1')) {
            $clean = '0' . $clean;
        }

        // 88017... thakle 017... kora
        if (strlen($clean) === 13 && str_starts_with($clean, '880')) {
            $clean = substr($clean, 2);
        }

        return $clean;
    }

    protected function generateUniqueId(string $roadNum, string $holdingNo, ?string $flatNo, string $plotType): string
    {
        $roadPad = str_pad($roadNum, 2, '0', STR_PAD_LEFT);
        $cleanHolding = preg_replace('/[^A-Za-z0-9]/', '', $holdingNo);

        $suffix = 'MAIN';
        if (str_contains(strtolower($plotType), 'empty')) {
            $suffix = 'EMT';
        } elseif (str_contains(strtolower($plotType), 'construction')) {
            $suffix = 'CONS';
        } elseif ($flatNo) {
            $suffix = preg_replace('/[^A-Za-z0-9]/', '', $flatNo);
        }

        $base = "UTR03-{$roadPad}-{$cleanHolding}-{$suffix}";
        $base = substr($base, 0, 24);

        $final = $base;
        if (isset($this->usedUniqueIds[$final])) {
            $this->usedUniqueIds[$final]++;
            $final = $base . '-' . $this->usedUniqueIds[$final];
        } else {
            $this->usedUniqueIds[$final] = 1;
        }

        return $final;
    }
}
