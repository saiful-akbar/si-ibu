<?php

if (!function_exists('user')) {

	/**
	 * Fungsi global user user
	 * 
	 * @return object
	 */
	function user()
	{
		return auth()->user();
	}
}

if (!function_exists('profil')) {

	/**
	 * Fungsi global user profil
	 * 
	 * @return object
	 */
	function profil()
	{
		return auth()->user()->profil;
	}
}

if (!function_exists('divisi')) {

	/**
	 * Fungsi global user divisi
	 * 
	 * @return object
	 */
	function divisi()
	{
		return auth()->user()->divisi;
	}
}

if (!function_exists('pengaturan')) {

	/**
	 * Fungsi global user pengaturan
	 * 
	 * @return object
	 */
	function pengaturan()
	{
		return auth()->user()->pengaturan;
	}
}

if (!function_exists('menu')) {

	/**
	 * Fungsi global user menu header & item
	 * 
	 * @return object
	 */
	function menu()
	{
		return auth()->user()->load([
            'menuHeader' => fn ($query) => $query->orderBy('no_urut', 'asc'),
            'menuItem' => fn ($query) => $query->orderBy('nama_menu', 'asc'),
        ]);
	}
}