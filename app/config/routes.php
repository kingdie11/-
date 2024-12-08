<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

$router->get('/', 'Welcome::index');
$router->get('/login', 'AuthController::login');
$router->get('/register', 'AuthController::register');
$router->match('/register/submit', 'AuthController::register', 'GET|POST');
$router->match('/log', 'AuthController::login', 'GET|POST');
$router->match('/email', 'PageController::sendEmail', 'GET|POST');
$router->get('/job', 'PageController::viewjob');
$router->get('/bout', 'PageController::viewabout');
$router->get('/contact', 'PageController::viewcontact');
$router->get('/home', 'AuthController::getuserid');
$router->get('/logout', 'AuthController::logout');
$router->get('/profile', 'ProfileController::manageProfile');
$router->post('/createProfile/submit', 'ProfileController::manageProfile');
$router->post('/createProfile/submit', 'ProfileController::updateProfile');
$router->get('/adminregister', 'AuthController::adminregister');
$router->match('/adminregister/submit', 'AuthController::adminregister', 'GET|POST');
$router->match('/adminlog', 'AuthController::adminlogin', 'GET|POST');
$router->get('/adminhome', 'PageController::viewadminhome');
$router->get('/adminlogout', 'AuthController::adminlogout');
$router->get('/viewpostjob', 'EmployeeController::postJob');
$router->match('/postjob/submit', 'EmployeeController::postJob', 'GET|POST');
$router->match('/applyjob/submit', 'JobController::applyJob', 'GET|POST');
$router->post('/editjob/submit', 'JobController::editJob');
$router->post('/updateapplystatus/submit', 'JobController::updateApplicationStatus');
$router->get('/adminprofile', 'AdminController::manageAdmin');
$router->post('/createAdmin/submit', 'AdminController::manageAdmin');
$router->post('/createAdmin/submit', 'AdminController::updateCompanyProfile');
$router->get('/forgotpassword', 'PageController::viewforgotpass');
$router->match('/verifyemail/submit', 'ResetController::verifyEmail', 'POST');
$router->match('/verifyanswer/submit', 'ResetController::verifyAnswer', 'POST');
$router->match('/resetpassword/submit', 'ResetController::updatePassword', 'POST');