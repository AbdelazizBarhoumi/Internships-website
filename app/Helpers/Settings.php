<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Settings
{
    /**
     * Get a setting value
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = 'setting_' . $key;
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = DB::table('settings')->where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return json_decode($setting->value, true);
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value, ?string $description = null)
    {
        $data = [
            'value' => json_encode($value),
            'updated_at' => now(),
        ];
        
        if ($description !== null) {
            $data['description'] = $description;
        }
        
        DB::table('settings')->updateOrInsert(
            ['key' => $key],
            $data
        );
        
        // Clear the cache for this setting
        Cache::forget('setting_' . $key);
        
        return true;
    }

    /**
     * Get all settings
     */
    public static function all()
    {
        return Cache::remember('all_settings', 3600, function () {
            $settings = DB::table('settings')->get();
            
            $result = [];
            foreach ($settings as $setting) {
                $result[$setting->key] = json_decode($setting->value, true);
            }
            
            return $result;
        });
    }
}