<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class QRCodeService
{
    /**
     * Generate QR Code dengan data sederhana (hanya text)
     * Lebih ringan dan cepat
     */
    public static function generateSimpleQRCode($text)
    {
        try {
            // Pastikan folder exist
            if (!Storage::disk('public')->exists('qr_codes')) {
                Storage::disk('public')->makeDirectory('qr_codes');
                Log::info('QR Codes folder created');
            }
            
            $encoded = urlencode($text);
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={$encoded}";
            
            Log::info("Generating QR Code from: {$qrUrl}");
            
            $response = Http::timeout(10)->retry(3, 100)->get($qrUrl);
            
            if ($response->successful()) {
                $filename = 'qr_codes/qr_' . time() . '_' . uniqid() . '.png';
                Storage::disk('public')->put($filename, $response->body());
                
                Log::info("QR Code saved successfully: {$filename}");
                
                return [
                    'success' => true,
                    'path' => $filename,
                    'url' => Storage::url($filename)
                ];
            }
            
            Log::error('QR API Response Failed: Status ' . $response->status());
            return ['success' => false, 'message' => 'API Response Error: ' . $response->status()];
            
        } catch (\Exception $e) {
            Log::error('QR Generation Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Generate QR Code langsung sebagai Base64 (tanpa save file)
     * Cocok untuk ditampilkan langsung di HTML
     */
    public static function generateQRCodeBase64($text)
    {
        try {
            $encoded = urlencode($text);
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={$encoded}";
            
            $response = Http::timeout(10)->retry(3, 100)->get($qrUrl);
            
            if ($response->successful()) {
                $base64 = base64_encode($response->body());
                return [
                    'success' => true,
                    'base64' => 'data:image/png;base64,' . $base64
                ];
            }
            
            return ['success' => false, 'message' => 'Failed to generate QR'];
            
        } catch (\Exception $e) {
            Log::error('QR Base64 Generation Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Generate QR Code menggunakan API gratis (qr-server.com)
     * QR Code berisi data dalam format JSON
     */
    public static function generateQRCode($data)
    {
        try {
            // Pastikan folder exist
            if (!Storage::disk('public')->exists('qr_codes')) {
                Storage::disk('public')->makeDirectory('qr_codes');
            }
            
            // Data Absensi yang akan di-encode ke QR
            $qrData = json_encode($data);
            
            // URL encode data
            $encoded = urlencode($qrData);
            
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={$encoded}";
            
            // Fetch QR Code Image
            $response = Http::timeout(10)->retry(3, 100)->get($qrUrl);
            
            if ($response->successful()) {
                // Generate unique filename
                $filename = 'qr_codes/qr_' . time() . '_' . uniqid() . '.png';
                
                // Store ke storage/app/public
                Storage::disk('public')->put($filename, $response->body());
                
                return [
                    'success' => true,
                    'path' => $filename,
                    'url' => Storage::url($filename),
                    'message' => 'QR Code generated successfully'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Failed to generate QR Code from API'
            ];
            
        } catch (\Exception $e) {
            Log::error('QR Code Generation Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
    
