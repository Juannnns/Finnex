<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $defaultSettings = [
            // Accessibility
            'a11y_high_contrast'    => false,
            'a11y_text_size'        => 'normal',
            'a11y_simplified'       => false,
            'a11y_no_animations'    => false,
            'a11y_clear_language'   => false,
            'a11y_screen_reader'    => false,

            // Notifications (Beta)
            'notifications_email'   => true,
            'notifications_push'    => true,
            'notifications_alerts'  => true,
            'notifications_weekly'  => false,

            // Display & Locale (Beta)
            'currency'              => 'MXN',
            'language'              => 'es',
            'theme'                 => 'dark',
            'date_format'           => 'DD/MM/YYYY',
            'privacy_incognito'     => false,

            // Privacy & Security (Beta)
            'privacy_profile'       => 'private',
            'two_factor'            => false,
            'session_timeout'       => '30',

            // AI & Automation (Beta)
            'beta_ai_insights'      => true,
            'beta_auto_categorize'  => true,
            'beta_finbot_mode'      => 'detailed',
            'beta_budget_forecast'  => true,
        ];

        $settings = array_merge($defaultSettings, session('finnex_settings', []));

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $currentSettings = session('finnex_settings', []);

        $request->validate([
            'currency'        => 'nullable|in:MXN,USD,EUR,COP,ARS',
            'language'        => 'nullable|in:es,en',
            'theme'           => 'nullable|in:dark,light',
            'privacy_profile' => 'nullable|in:private,public',
        ]);

        $newSettings = [
            // Accessibility
            'a11y_high_contrast'    => $request->boolean('a11y_high_contrast'),
            'a11y_text_size'        => $request->input('a11y_text_size', $currentSettings['a11y_text_size'] ?? 'normal'),
            'a11y_simplified'       => $request->boolean('a11y_simplified'),
            'a11y_no_animations'    => $request->boolean('a11y_no_animations'),
            'a11y_clear_language'   => $request->boolean('a11y_clear_language'),
            'a11y_screen_reader'    => $request->boolean('a11y_screen_reader'),

            // Notifications (Beta)
            'notifications_email'   => $request->boolean('notifications_email'),
            'notifications_push'    => $request->boolean('notifications_push'),
            'notifications_alerts'  => $request->boolean('notifications_alerts'),
            'notifications_weekly'  => $request->boolean('notifications_weekly'),

            // Display (Beta)
            'currency'              => $request->input('currency', $currentSettings['currency'] ?? 'MXN'),
            'language'              => $request->input('language', $currentSettings['language'] ?? 'es'),
            'theme'                 => $request->input('theme', $currentSettings['theme'] ?? 'dark'),
            'date_format'           => $request->input('date_format', $currentSettings['date_format'] ?? 'DD/MM/YYYY'),
            'privacy_incognito'     => $request->boolean('privacy_incognito'),

            // Privacy (Beta)
            'privacy_profile'       => $request->input('privacy_profile', $currentSettings['privacy_profile'] ?? 'private'),
            'two_factor'            => $request->boolean('two_factor'),
            'session_timeout'       => $request->input('session_timeout', $currentSettings['session_timeout'] ?? '30'),

            // AI & Automation (Beta)
            'beta_ai_insights'      => $request->boolean('beta_ai_insights'),
            'beta_auto_categorize'  => $request->boolean('beta_auto_categorize'),
            'beta_finbot_mode'      => $request->input('beta_finbot_mode', $currentSettings['beta_finbot_mode'] ?? 'detailed'),
            'beta_budget_forecast'  => $request->boolean('beta_budget_forecast'),
        ];

        session(['finnex_settings' => array_merge($currentSettings, $newSettings)]);

        $activeSection = $request->input('active_section', 'accessibility');

        return back()->with('success', '¡Configuración guardada correctamente!')
                     ->with('active_section', $activeSection);
    }

    public function exportData()
    {
        $export = [
            'app'         => 'FINNEX',
            'version'     => '1.0.0-beta',
            'exported_at' => now()->toIso8601String(),
            'user'        => session('finnex_user'),
            'settings'    => session('finnex_settings'),
        ];

        return response()->streamDownload(function () use ($export) {
            echo json_encode($export, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, 'finnex-config-beta.json', ['Content-Type' => 'application/json']);
    }

    public function resetDemoData()
    {
        session()->forget('finnex_settings');
        return back()->with('success', '¡Configuraciones demo restablecidas a los valores de fábrica!')
                     ->with('active_section', 'danger');
    }

    public function deleteAccount(Request $request)
    {
        // Demo: just logout
        session()->flush();
        return redirect()->route('login')->with('info', 'Cuenta eliminada (demo).');
    }
}
