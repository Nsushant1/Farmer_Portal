<?php
class CropManagement {
  public function addCrop($cropName, $description, $price, $quantity) {
    // code to add crop to database
  }
  
  public function updateCrop($cropId, $cropName, $description, $price, $quantity) {
    // code to update crop in database
  }
  
  public function getCrops() {
    // code to get crops from database
  }
  
  public function deleteCrop($cropId) {
    // code to delete crop from database
  }
}

class Farmerportal {
  public function addFarmer($farmerName, $email, $password) {
    // code to add farmer to database
  }
  
  public function updateFarmer($farmerId, $farmerName, $email, $password) {
    // code to update farmer in database
  }
  
  public function getFarmers() {
    // code to get farmers from database
  }
  
  public function deleteFarmer($farmerId) {
    // code to delete farmer from database
  }
  
  public function getCropsForFarmer($farmerId) {
    // code to get crops for a farmer from database
  }
}

$cropManagement = new Cropmanagement();
$farmerportal = new Farmerportal();

// code to add a crop
$cropManagement->addCrop("Tomato", "Red Tomato", 10, 100);

// code to add a farmer
$farmerportal->addFarmer("John Doe", "john@example.com", "password123");

// code to get crops
$crops = $cropManagement->getCrops();

// code to get farmers
$farmers = $farmerportal->getFarmers();

// code to get crops for a farmer
$cropsForFarmer = $farmerportal->getCropsForFarmer(1);
