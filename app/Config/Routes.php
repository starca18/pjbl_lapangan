<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public User Routes
$routes->get('/', 'Home::index');
$routes->get('jadwal', 'Jadwal::index');
$routes->get('jadwal/slots-data', 'Jadwal::slotsData');

$routes->get('booking', 'Booking::index');
$routes->get('booking/detail/(:num)', 'Booking::detail/$1');
$routes->post('booking/process', 'Booking::process');
$routes->get('booking/success/(:segment)', 'Booking::success/$1');
$routes->get('lacak', 'Booking::lacak');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');

// Admin Protected Routes
$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    $routes->get('jadwal', 'Admin\Jadwal::index');

    $routes->get('bookings', 'Admin\Bookings::index');
    $routes->get('bookings/create', 'Admin\Bookings::create');
    $routes->post('bookings/store', 'Admin\Bookings::store');
    $routes->get('bookings/detail/(:num)', 'Admin\Bookings::detail/$1');
    $routes->post('bookings/update-status/(:num)', 'Admin\Bookings::updateStatus/$1');
    $routes->get('bookings/print/(:num)', 'Admin\Bookings::printReceipt/$1');

    $routes->get('courts', 'Admin\Courts::index');
    $routes->get('courts/create', 'Admin\Courts::create');
    $routes->post('courts/store', 'Admin\Courts::store');
    $routes->get('courts/edit/(:num)', 'Admin\Courts::edit/$1');
    $routes->post('courts/update/(:num)', 'Admin\Courts::update/$1');
    $routes->post('courts/toggle/(:num)', 'Admin\Courts::toggleStatus/$1');
    $routes->post('courts/delete/(:num)', 'Admin\Courts::delete/$1');
});
