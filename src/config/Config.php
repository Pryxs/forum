<?php

namespace App\config;

// .env => convention, ignorer par git (evite les accident)
// class Config => est une parti du code, permet de préciser ce qui est attendu
class Config 
{
    const PATH_SQLITE_FILE = 'database/db.sqlite';
}