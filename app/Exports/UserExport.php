<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function collection()
    {
        return User::where('role', $this->role)->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Email',
            'Password',
        ];
    }

    public function map($user): array
    {
        // Menghasilkan password berdasarkan pola tertentu (misalnya, 4 karakter pertama email + ID)
        $generatedPassword = substr($user->email, 0, 4) . $user->id;
        $passwordText = 'This account already edited the password';

        if (Hash::check($generatedPassword, $user->password)) {
            $passwordText = $generatedPassword;
        } elseif (Hash::check('admin123', $user->password)) {
            $passwordText = 'admin123';
        } elseif (Hash::check('adminwikrama', $user->password)) {
            $passwordText = 'adminwikrama';
        } elseif (Hash::check('operator123', $user->password)) {
            $passwordText = 'operator123';
        }

        return [
            $user->name,
            $user->email,
            $passwordText,
        ];
    }
}
