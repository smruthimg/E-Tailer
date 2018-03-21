<?php

class Cart{
	private $UserID;
	private $LastName;
	private $FirstName;
	private $UserType;
  private $Password;
  

//get Properties
 public function getID(){
   return $this->UserID;
 }
  public function getCartID(){
   return $this->CartID;
 }
  public function getProductID(){
   return $this->ProductID;
 }
  public function getQTY(){
   return $this->QTY;
 }
 public function getAmt(){
   return $this->Amt;
 }
 //Set Properties
 public function setID($UserID){
   return $this->UserID;
 }
  public function setCartID($CartID){
   return $this->CartID;
 }
  public function setQTY($QTY){
   return $this->QTY;
 }
  public function setProductID($ProductID){
   return $this->ProductID;
 }
 public function setAmt($Amt){
   return $this->Amt;
 }
}