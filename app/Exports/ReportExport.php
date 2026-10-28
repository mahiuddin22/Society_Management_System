<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ReportExport extends DefaultValueBinder implements FromArray, WithHeadings, WithCustomValueBinder
{
    public function __construct(private array $headings, private array $rows) {}
    public function headings(): array { return $this->headings; }
    public function array(): array { return $this->rows; }

    public function bindValue(Cell $cell, $value): bool
    {
        if (is_string($value) && preg_match('/^\d+$/', $value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
