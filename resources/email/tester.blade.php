<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Users Report - Roomly</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
        <tr>
            <td align="center">
                <table width="650" style="background:#ffffff; border-radius:8px; overflow:hidden; border: 1px solid #e2e8f0;">
                    
                    <tr>
                        <td style="background:#0f172a; color:#ffffff; padding:25px;">
                            <h2 style="margin:0; font-size: 24px;">👤 Users Report</h2>
                            <p style="margin:5px 0 0 0; opacity: 0.8;">Laporan pendaftaran user terbaru sistem Roomly</p>
                            <small style="display:block; margin-top:10px; color:#94a3b8;">Dicetak pada: {{ now()->format('d M Y H:i') }}</small>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:30px;">
                            <p style="color:#334155; font-size: 16px; line-height: 1.5;">
                                Halo Admin, <br><br>
                                Berikut adalah daftar 10 user terbaru yang baru saja bergabung atau dibuat melalui sistem:
                            </p>

                            <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse; margin-top:20px; font-size: 14px;">
                                <thead>
                                    <tr style="background:#f8fafc; border-bottom: 2px solid #e2e8f0;">
                                        <th align="left" style="color:#475569;">ID</th>
                                        <th align="left" style="color:#475569;">Nama</th>
                                        <th align="left" style="color:#475569;">Email</th>
                                        <th align="left" style="color:#475569;">Role</th>
                                        <th align="left" style="color:#475569;">Daftar Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr style="border-bottom:1px solid #f1f5f9;">
                                            <td style="color:#64748b;">#{{ $user->id }}</td>
                                            <td style="font-weight:bold; color:#1e293b;">{{ $user->name }}</td>
                                            <td style="color:#0ea5e9;">{{ $user->email }}</td>
                                            <td>
                                                <span style="padding:2px 8px; background:#e0f2fe; color:#0369a1; border-radius:4px; font-size:12px;">
                                                    {{ strtoupper($user->role) }}
                                                </span>
                                            </td>
                                            <td style="color:#64748b;">{{ $user->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" align="center" style="padding:20px; color:#94a3b8;">
                                                Belum ada data user tersedia.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f8fafc; padding:20px; text-align:center; font-size:12px; color:#64748b; border-top: 1px solid #e2e8f0;">
                            <strong>Total User Aktif: {{ \App\Models\User::count() }}</strong> <br>
                            Laporan ini dihasilkan secara otomatis oleh sistem backend Laravel Roomly. <br>
                            &copy; {{ date('Y') }} Roomly Project.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>