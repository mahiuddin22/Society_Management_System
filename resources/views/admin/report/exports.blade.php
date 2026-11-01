<div class="d-flex flex-wrap gap-2 mb-3">
@foreach(['csv'=>'CSV','xlsx'=>'Excel','pdf'=>'PDF'] as $format => $label)
<a class="btn btn-outline-secondary btn-sm" href="{{ request()->fullUrlWithQuery(['export'=>$format]) }}" @if($format === 'pdf') data-report-pdf @endif>Download {{ $label }}</a>
@endforeach
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const link = document.querySelector('[data-report-pdf]');
    if (!link || !window.pdfMake) return;

    link.addEventListener('click', function (event) {
        event.preventDefault();
        const pdfUrl = new URL(link.href, window.location.href);
        try {
            const reportTable = document.querySelector('.panel.active .ledger');
            if (!reportTable) throw new Error('Could not find the report table.');
            const headings = Array.from(reportTable.querySelectorAll('thead th'), (cell) => cell.innerText.trim());
            const rows = Array.from(reportTable.querySelectorAll('tbody tr'))
                .filter((row) => row.querySelectorAll('td').length === headings.length)
                .map((row) => Array.from(row.querySelectorAll('td'), (cell) => cell.innerText.trim()));
            if (!rows.length) throw new Error('There are no report rows to export.');
            const titles = {
                'plot-management': 'Plot Management Report',
                'bill-collections': 'Bill Collections Report',
                'bulk-sms': 'SMS History Report'
            };
            const reportKey = pdfUrl.pathname.split('/').filter(Boolean).pop();
            const title = titles[reportKey] || 'Report';
            const isBillCollections = reportKey === 'bill-collections';
            const body = [
                headings.map((heading) => ({ text: heading, style: 'tableHeader', fillColor: '#222222' })),
                ...rows.map((row, rowIndex) => headings.map((_, index) => ({
                    text: row[index] || '',
                    fillColor: rowIndex % 2 === 0 ? '#eeeeee' : '#ffffff'
                })))
            ];
            const widths = headings.map(() => '*');
            const fileName = (reportKey || 'report').replace(/[^a-z0-9_-]/gi, '-');

            pdfMake.createPdf({
                pageSize: 'A4', pageOrientation: 'landscape', pageMargins: isBillCollections ? [18, 58, 18, 36] : [36, 62, 36, 44],
                header: { text: title, margin: [36, 20, 36, 0], color: '#222222', fontSize: 9 },
                footer: (current, total) => ({ text: `Page ${current} of ${total}`, alignment: 'right', margin: [36, 0, 36, 18], color: '#222222', fontSize: 8 }),
                content: [
                    { text: title, style: 'title' },
                    { text: `${rows.length} records  ·  Generated ${new Date().toLocaleString()}`, style: 'subtitle' },
                    { table: { headerRows: 1, widths, body }, layout: {
                        hLineColor: () => '#777777', vLineColor: () => '#777777', hLineWidth: () => 0.6, vLineWidth: () => 0.4,
                        paddingLeft: () => isBillCollections ? 3 : 7,
                        paddingRight: () => isBillCollections ? 3 : 7,
                        paddingTop: () => isBillCollections ? 4 : 6,
                        paddingBottom: () => isBillCollections ? 4 : 6
                    } }
                ],
                styles: {
                    title: { fontSize: 18, bold: true, color: '#111111', margin: [0, 0, 0, 5] },
                    subtitle: { fontSize: 9, color: '#333333', margin: [0, 0, 0, 14] },
                    tableHeader: { bold: true, color: '#ffffff', fontSize: isBillCollections ? 6 : 8 }
                },
                defaultStyle: { fontSize: isBillCollections ? 6 : 8, color: '#263445' }
            }).download(`${fileName}.pdf`);
        } catch (error) {
            alert(error.message || 'PDF export failed.');
        }
    });
});
</script>
