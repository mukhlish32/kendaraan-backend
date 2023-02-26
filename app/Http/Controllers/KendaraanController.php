<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Services\KendaraanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{    
    private KendaraanService $kendaraanService;
	public function __construct() 
    {
		$this->kendaraanService = new KendaraanService();
	}

    public function showKendaraan()
    {
        $kendaraan = $this->kendaraanService->getKendaraan();

        return response()->json([
            'success' => true,
            'message' => 'List Data Kendaraan',
            'data'    => $kendaraan
        ], 200);
    }
    
    public function showKendaraanById($id)
    {
        $kendaraan = $this->kendaraanService->getKendaraanById($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kendaraan',
            'data'    => $kendaraan
        ], 200);
    }
    
    public function createKendaraan(Request $request)
    {
        $request->validate([
            'merk'   => 'required|string',
            'tahun_release' => 'required',
        ]);
    
        $data = [
			'merk'=>$request->post('merk'),
			'tahun_release'=>$request->post('tahun_release')
		];

        $id = $this->kendaraanService->addKendaraan($data);
        $kendaraan = $this->kendaraanService->getKendaraanById($id);
        
        if($kendaraan) {
            return response()->json([
                'success' => true,
                'message' => 'Data Kendaraan berhasil disimpan',
                'data'    => $kendaraan  
            ], 201);
        } 

        return response()->json([
            'success' => false,
            'message' => 'Data kendaraan gagal disimpan',
        ], 409);
    }
    
    public function updateKendaraan(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'merk' => 'required|string',
            'tahun_release' => 'required|numeric',
            'mobil'=>'array',
        ]);
        
        $kendaraanId = $request->post('id');
        $formData = $request->only('merk', 'tahun_release', 'mobil');
		$data = $this->kendaraanService->getKendaraanById($kendaraanId);

        $this->kendaraanService->updateKendaraan($data, $formData);
        $kendaraan = $this->kendaraanService->getKendaraanById($id);

        if($kendaraan) {
            return response()->json([
                'success' => true,
                'message' => 'Data Kendaraan berhasil diupdate',
                'data'    => $kendaraan
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Data Kendaraan gagal diupdate',
        ], 404);
    }
    
    public function deleteKendaraan(Request $request)
    {
        $request->validate([
			'kendaraan_id'=>'required'
		]);

        $kendaraanId = $request->kendaraan_id;
        $kendaraan = $this->kendaraanService->getKendaraanById($kendaraanId);
        if($kendaraan) {
            $this->kendaraanService->deleteKendaraan($kendaraanId);
            return response()->json([
                'success' => true,
                'message' => 'Data Kendaraan berhasil dihapus',
                'data'    => $kendaraan
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Data Kendaraan tidak ditemukan',
        ], 404);
    }

    public function addMobilInKendaraan(Request $request)
	{
		$request->validate([
			'kendaraan_id' => 'required',
			'warna' => 'required|string',
			'kapasitas' => 'required|string',
            'harga' => 'required'
		]);

        $kendaraanId = $request->post('kendaraan_id');
		$kendaraan = $this->kendaraanService->getKendaraanById($kendaraanId);
		if(!$kendaraan)
		{
			return response()->json([
				"message"=> "Kendaraan ".$kendaraanId." tidak ada"
			], 401);
		}

		$mobil = [
			'_id' => (string) new \MongoDB\BSON\ObjectId(),
			'warna' => $request->post('warna'),
			'kapasitas' => $request->post('kapasitas'),
            'harga' => $request->post('harga'),
		];

		$this->kendaraanService->addMobilInKendaraan($kendaraan, $mobil);
		$data = $this->kendaraanService->getKendaraanById($kendaraanId);
		return response()->json($data);
	}

    public function deleteMobilInKendaraan(Request $request)
	{
		$request->validate([
			'kendaraan_id'=>'required',
			'mobil_id'=>'required'
		]);

		$kendaraanId = $request->post('kendaraan_id');
		$mobilId = $request->post('mobil_id');
		$kendaraan = $this->kendaraanService->getKendaraanById($kendaraanId);
		if(!$kendaraan)
		{
			return response()->json([
				"message"=> "Kendaraan ".$taskId." tidak ada"
			], 401);
		}

		$this->kendaraanService->deleteMobilInKendaraan($kendaraan, $mobilId);
		$data = $this->kendaraanService->getKendaraanById($taskId);
		return response()->json($data);
	}
}