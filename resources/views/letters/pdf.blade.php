<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 16px; }
        .brand { font-size: 16px; font-weight: bold; color: #2563eb; }
        .meta { margin-top: 8px; font-size: 11px; color: #334155; }
        .title { font-size: 14px; font-weight: bold; margin: 10px 0; }
        .box { border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px; }
        .footer { margin-top: 18px; font-size: 10px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">POSTRA</div>
        <div class="meta">
            Tanggal: {{ $date->format('d M Y H:i') }}<br>
            Dari: {{ $sender->name }} ({{ $sender->email }})<br>
            Kepada: {{ $recipient->name }} ({{ $recipient->email }})
        </div>
    </div>

    <div class="title">{{ $subject }}</div>

    <div class="box">
        {!! nl2br(e($body)) !!}
    </div>

    <div class="footer">
        Dokumen ini dibuat melalui Postra. (Surat digital berformat PDF)
    </div>
</body>
</html>
