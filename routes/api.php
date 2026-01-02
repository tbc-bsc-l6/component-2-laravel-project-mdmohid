<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Example API route
Route::get('/test', function () {
  return response()->json(['message' => 'API works!']);
});
