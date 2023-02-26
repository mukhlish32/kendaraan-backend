<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;

class KendaraanService {
	private KendaraanRepository $kendaraanRepository;

	public function __construct() {
		$this->kendaraanRepository = new KendaraanRepository();
	}

	public function getKendaraan()
	{
		$kendaraan = $this->kendaraanRepository->getAll();
		return $kendaraan;
	}

	public function getKendaraanById(string $kendaraanId)
	{
		$kendaraanId = $this->kendaraanRepository->getById($kendaraanId);
		return $kendaraanId;
	}

    public function addKendaraan(array $data)
	{
		$kendaraanId = $this->kendaraanRepository->create($data);
		return $kendaraanId;
	}

	public function updateKendaraan(array $editData, array $formData)
	{
		if(isset($formData['merk'])) $editData['merk'] = $formData['merk'];
		if(isset($formData['tahun_release'])) $editData['tahun_release'] = $formData['tahun_release'];

		$id = $this->kendaraanRepository->save($editData);
		return $id;
	}

	public function deleteKendaraan(string $kendaraanId)
	{
		$this->kendaraanRepository->delete($kendaraanId);
	}

	public function addMobilInKendaraan(array $kendaraan, array $mobil)
	{
		if(isset($mobil))
		{
			$kendaraan['mobil'][] = $mobil;
		}

		$id = $this->kendaraanRepository->save($kendaraan);
		return $id;
	}

	public function deleteMobilInKendaraan(array $kendaraan, string $mobilId)
	{
		if(isset($mobilId))
		{
			$kendaraan['detail'] = array_filter($kendaraan['detail'], function($mobil) use($mobilId) {
				if($mobil['_id'] == $mobilId)
				{
				    return false;
				} else {
					return true;
				}
			});
		}

		$id = $this->kendaraanRepository->save($editTask);
		return $id;
	}
}