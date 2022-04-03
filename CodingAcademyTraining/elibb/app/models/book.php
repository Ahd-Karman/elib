<?php 
namespace coding\app\models;

class Book extends Model{
    function __construct()
    {
        parent::$tblName="books";
        
    }
}