<?php
namespace App\Enums;

enum RoleEnum: string {
    case KEPSEK ='kepsek';
    case GURU = 'guru';
    case PENGAWAS = 'pengawas';

    public function label() : string{
        return match($this){
            self::KEPSEK => 'Kepalas Sekolah',
            self::GURU => 'Guru',
            self::PENGAWAS => 'Pengawas',
        };
    }
}
