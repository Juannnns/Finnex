<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinSafeController extends Controller
{
    public function index()
    {
        $data = [
            'security_score' => 94,
            'security_level' => 'Alto',
            'security_color' => 'success',

            'alerts' => [
                [
                    'id'    => 1,
                    'level' => 'high',
                    'icon'  => '⚠️',
                    'title' => 'Transacción inusual detectada',
                    'desc'  => 'Se realizó un pago de $89.990 desde Concepción, una ubicación diferente a tu comportamiento habitual. ¿Reconoces esta transacción?',
                    'time'  => 'Hace 2 horas',
                    'status'=> 'pending',
                    'detail'=> ['merchant' => 'Tienda Tecnológica Norte', 'location' => 'Concepción, Chile', 'amount' => 89990, 'method' => 'Tarjeta de débito'],
                ],
                [
                    'id'    => 2,
                    'level' => 'medium',
                    'icon'  => '🔑',
                    'title' => 'Intento de acceso no reconocido',
                    'desc'  => 'Se detectaron 3 intentos de inicio de sesión fallidos desde un dispositivo desconocido (IP: 190.x.x.x).',
                    'time'  => 'Ayer, 23:47',
                    'status'=> 'pending',
                    'detail'=> ['device' => 'Navegador Chrome desconocido', 'ip' => '190.xxx.xxx.xxx', 'location' => 'Antofagasta, Chile', 'attempts' => 3],
                ],
                [
                    'id'    => 3,
                    'level' => 'low',
                    'icon'  => '📍',
                    'title' => 'Nueva ubicación detectada',
                    'desc'  => 'Accediste desde una ubicación nueva: Vitacura, Santiago. Si fuiste tú, puedes ignorar esta alerta.',
                    'time'  => 'Hace 3 días',
                    'status'=> 'resolved',
                    'detail'=> ['location' => 'Vitacura, Santiago', 'device' => 'iPhone 15 Pro - Safari', 'time' => '04 Oct, 15:30'],
                ],
            ],

            'suspicious_transactions' => [
                ['date' => 'Hoy 10:22',    'merchant' => 'Tienda Tecnológica Norte', 'amount' => 89990,  'risk' => 'high',   'reason' => 'Ubicación inusual'],
                ['date' => 'Ayer 02:14',   'merchant' => 'Transferencia online',     'amount' => 15000,  'risk' => 'medium', 'reason' => 'Horario atípico'],
                ['date' => '03 Oct 18:45', 'merchant' => 'App Store',                'amount' => 9990,   'risk' => 'low',    'reason' => 'Primera compra en plataforma'],
            ],

            'devices' => [
                ['name' => 'iPhone 15 Pro',      'os' => 'iOS 18.1',     'location' => 'Santiago, Chile',    'time' => 'Ahora',          'active' => true],
                ['name' => 'MacBook Pro 14"',    'os' => 'macOS 14.7',   'location' => 'Santiago, Chile',    'time' => 'Hace 1 hora',    'active' => true],
                ['name' => 'Chrome / Windows',   'os' => 'Windows 11',   'location' => 'Santiago, Chile',    'time' => 'Ayer, 20:30',    'active' => false],
                ['name' => 'iPad Air',           'os' => 'iPadOS 18.0',  'location' => 'Viña del Mar',       'time' => 'Hace 5 días',    'active' => false],
            ],

            'recommendations' => [
                ['icon' => '🔐', 'title' => 'Activa la autenticación de dos factores', 'desc' => 'Protege tu cuenta con una capa adicional de seguridad.', 'done' => false],
                ['icon' => '📱', 'title' => 'Revisa los dispositivos vinculados', 'desc' => '4 dispositivos activos. Revisa si todos son reconocidos.', 'done' => false],
                ['icon' => '🔑', 'title' => 'Contraseña actualizada hace 6 meses', 'desc' => 'Se recomienda cambiar la contraseña cada 90 días.', 'done' => false],
                ['icon' => '✅', 'title' => 'Alertas de transacciones activadas', 'desc' => 'Recibes notificaciones por cada movimiento en tu cuenta.', 'done' => true],
            ],
        ];

        return view('finsafe.index', $data);
    }

    public function dismissAlert(Request $request, int $id)
    {
        // In a real app: mark alert as dismissed in DB
        return response()->json(['success' => true, 'message' => 'Alerta marcada como revisada.']);
    }
}
