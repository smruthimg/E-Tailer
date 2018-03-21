<?php

class User{
	private $UserID;
	private $LastName;
	private $FirstName;
	private $UserType;
  private $Password;
  

//get Properties
 public function getID(){
   return $this->UserID;
 }
  public function getFirstName(){
   return $this->FirstName;
 }
  public function getLastName(){
   return $this->LastName;
 }
  public function getUserType(){
   return $this->UserType;
 }
 public function getPassword(){
   return $this->Password;
 }
 //Set Properties
 public function setID($UserID){
   return $this->UserID;
 }
  public function setFirstName($FirstName){
   return $this->FirstName;
 }
  public function setLastName($LastName){
   return $this->LastName;
 }
  public function setUserType($UserType){
   return $this->UserType;
 }
 public function setPassword($Password){
   return $this->Password;
 }
}