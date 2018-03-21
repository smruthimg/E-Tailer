<?php

class Product{
	private $ProductID;
	private $ProdName;
	private $ProdDesc;
	private $Price;
  private $SalePrice;
  private $QTY;
  private $ImageURL;
  

//get Properties
 public function getID(){
   return $this->ProductID;
 }
  public function getProdName(){
   return $this->ProdName;
 }
  public function getProdDesc(){
   return $this->ProdDesc;
 }
  public function getPrice(){
   return $this->Price;
 }
 public function getSalePrice(){
   return $this->SalePrice;
 }
  public function getQTY(){
   return $this->QTY;
 }
  public function getImageURL(){
   return $this->ImageURL;
 }
 //Set Properties
 public function setID($ProductID){
   return $this->ProductID;
 }
 public function setProdDesc($ProdDesc){
   return $this->ProdDesc;
 }
  public function setProdName($ProdName){
   return $this->ProdName;
 }
  public function setPrice($Price){
   return $this->Price;
 }
  public function setSalePrice($SalePrice){
   return $this->SalePrice;
 }
 public function setQTY($QTY){
   return $this->QTY;
 }
 public function setImageURL($ImageURL){
   return $this->ImageURL;
 }
 
}