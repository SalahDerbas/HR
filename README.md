# Laravel HR Project API Documentation

This repository contains the API routes for a Laravel-based HR project. The routes are divided into different categories such as Authentication, User, Company, Lookup, and Messages.


## Features

### Authentication
- **User Login**: Login via email/password or third-party OAuth services (Google, Facebook, Apple).
- **OTP Verification**: One-time password (OTP) for enhanced security during login.
- **Password Reset**: Ability for users to reset their password via email.
- **Refresh Tokens**: Token refresh mechanism for maintaining user sessions.
- **User Profile Management**: View and update user profile information.
- **User Logout**: Logout functionality to invalidate the authentication token.

### Content Management
- **Terms and Conditions**: Retrieve the platform’s terms and conditions.
- **Privacy Policy**: Access the platform’s privacy policy.
- **About Us**: Information about the company or service.
- **FAQ**: Frequently asked questions to assist users.
- **Sliders**: Display promotional banners/sliders.
- **Contact Us**: Submit inquiries or feedback via the API.

### HR Features
- **Vacation Management**: 
  - Request, update, approve, and reject vacation requests.
- **Missing Punches**: 
  - Submit and manage missing attendance punches.
- **Leave Management**: 
  - Request, update, approve, and reject leave applications.
- **Experience Management**: 
  - Add, update, and delete professional experiences.
- **Event Management**: 
  - Create, update, and manage company events.
- **Document Management**: 
  - Upload and manage employee-related documents.
- **Certificate Management**: 
  - Manage certificates for employees (upload, update, delete).
- **Attendance Management**: 
  - Mark attendance, and approve/reject attendance entries.
- **Asset Management**: 
  - Track assets assigned to employees.
- **Dashboard**: 
  - Access a comprehensive dashboard with key HR statistics.

### Notification Management
- **Push Notifications**: 
  - Send notifications to users for important updates (e.g., vacation approval, missing punches).
- **Notification Preferences**: 
  - Enable or disable certain notifications based on user preferences.

### Lookup Data
- **Countries**: List of countries available in the system.
- **Genders**: Gender options available for user profiles.
- **Regions**: Geographical regions.
- **Material Status**: Status for materials or equipment (e.g., in use, available).
- **Work Types**: Types of work arrangements (e.g., remote, on-site).
- **Contract Types**: Different types of employment contracts (e.g., full-time, part-time).
- **User Status**: Current status of a user (e.g., active, inactive).
- **Attendance Status**: Status for attendance (e.g., present, absent).
- **Leave Reasons**: Predefined leave reasons for applications (e.g., personal, medical).
- **Leave Status**: Status of leave requests (approved, pending, rejected).
- **Vacation Types**: Different types of vacation (e.g., sick leave, annual leave).
- **Asset Types**: Categories of assets (e.g., laptops, phones, office furniture).
- **Missing Punch Types**: Categories for missing punch reasons.
- **Document Types**: Categories of employee documents (e.g., ID, employment contract).

### Company Management
- **Departments**: 
  - Manage company departments (CRUD operations).
- **Company Settings**: 
  - Manage and update company-wide settings and configurations.
- **Company Notifications**: 
  - Send company-wide notifications to users.

### API Security
- **JWT Authentication**: 
  - Secure all sensitive routes with JSON Web Token (JWT) authentication.
- **Token Expiry**: 
  - Expiring tokens to ensure secure access and session management.
- **Role-based Access Control**: 
  - Different access levels based on user roles (admin, employee, manager).

### Integration
- **OAuth 2.0 Integration**: 
  - Allows users to login through Google, Facebook, or Apple OAuth.
- **Third-party Integration**: 
  - Seamless integration with external systems for specific HR functions.

### Error Handling
- **API Error Responses**: 
  - Detailed error messages with HTTP status codes to help users troubleshoot issues.
- **Custom Error Messages**: 
  - User-friendly error messages to simplify debugging and improve the user experience.


## Table of Contents

- [Introduction](#introduction)
- [Authentication Routes](#authentication-routes)
- [User Routes](#user-routes)
- [Company Routes](#company-routes)
- [Lookup Routes](#lookup-routes)
- [Messages Routes](#messages-routes)

## Introduction

This API provides endpoints for managing user authentication, HR-related tasks, and system settings. It is designed for use with a mobile or web application that interacts with an HR management system.

## Authentication Routes

The following routes are available for managing user authentication:

### Public Routes
- **Login**: `POST /api/user/login`  
  Login using username and password.
- **Check OTP**: `POST /api/user/check-otp`  
  Check OTP during login.
- **Resend OTP**: `POST /api/user/re-send-otp`  
  Resend OTP if expired or not received.
- **Login with Google**: `POST /api/user/login-by-google`  
  Login using Google account.
- **Login with Facebook**: `POST /api/user/login-by-facebook`  
  Login using Facebook account.
- **Login with Apple**: `POST /api/user/login-by-apple`  
  Login using Apple ID.
- **Forgot Password**: `POST /api/user/forget-password`  
  Request a password reset.
- **Reset Password**: `POST /api/user/reset-password`  
  Reset the user's password.

### Authenticated Routes
The following routes are protected by authentication middleware (`auth:api`).

- **Get Profile**: `GET /api/user/get-profile`  
  Get the authenticated user's profile information.
- **Logout**: `GET /api/user/logout`  
  Log the user out and invalidate the session.
- **Update Profile**: `POST /api/user/update-profile`  
  Update the authenticated user's profile.
- **Delete Account**: `DELETE /api/user/delete`  
  Delete the authenticated user's account.

## User Routes

The user-related routes allow users to manage their HR-related data:

### Content Routes
- **Terms and Conditions**: `GET /api/user/content/terms-conditions`
- **Privacy Policy**: `GET /api/user/content/privacy-policy`
- **About Us**: `GET /api/user/content/about-us`
- **FAQ**: `GET /api/user/content/faq`
- **Sliders**: `GET /api/user/content/sliders`
- **Contact Us**: `POST /api/user/content/contact-us`

### Notifications
- **Get Notification List**: `GET /api/user/notification/list`
- **Update Notification Enable/Disable**: `GET /api/user/notification/update-enable`

### Vacation Routes
- **List Vacations**: `GET /api/user/vacation`
- **Show Vacation**: `GET /api/user/vacation/{id}`
- **Create Vacation**: `POST /api/user/vacation`
- **Update Vacation**: `POST /api/user/vacation/{id}`
- **Delete Vacation**: `DELETE /api/user/vacation/{id}`
- **Approve Vacation**: `GET /api/user/vacation/approve/{id}`
- **Reject Vacation**: `GET /api/user/vacation/reject/{id}`

### Missing Punches Routes
- **List Missing Punches**: `GET /api/user/missing-punches`
- **Show Missing Punch**: `GET /api/user/missing-punches/{id}`
- **Create Missing Punch**: `POST /api/user/missing-punches`
- **Update Missing Punch**: `POST /api/user/missing-punches/{id}`
- **Delete Missing Punch**: `DELETE /api/user/missing-punches/{id}`
- **Approve Missing Punch**: `GET /api/user/missing-punches/approve/{id}`
- **Reject Missing Punch**: `GET /api/user/missing-punches/reject/{id}`

### Leave Routes
- **List Leaves**: `GET /api/user/leave`
- **Show Leave**: `GET /api/user/leave/{id}`
- **Create Leave**: `POST /api/user/leave`
- **Update Leave**: `POST /api/user/leave/{id}`
- **Delete Leave**: `DELETE /api/user/leave/{id}`
- **Approve Leave**: `GET /api/user/leave/approve/{id}`
- **Reject Leave**: `GET /api/user/leave/reject/{id}`

### Experience Routes
- **List Experiences**: `GET /api/user/experince`
- **Show Experience**: `GET /api/user/experince/{id}`
- **Create Experience**: `POST /api/user/experince`
- **Update Experience**: `POST /api/user/experince/{id}`
- **Delete Experience**: `DELETE /api/user/experince/{id}`

### Event Routes
- **List Events**: `GET /api/user/event`
- **Show Event**: `GET /api/user/event/{id}`
- **Create Event**: `POST /api/user/event`
- **Update Event**: `POST /api/user/event/{id}`
- **Delete Event**: `DELETE /api/user/event/{id}`

### Document Routes
- **List Documents**: `GET /api/user/document`
- **Show Document**: `GET /api/user/document/{id}`
- **Create Document**: `POST /api/user/document`
- **Update Document**: `POST /api/user/document/{id}`
- **Delete Document**: `DELETE /api/user/document/{id}`

### Certificate Routes
- **List Certificates**: `GET /api/user/certificate`
- **Show Certificate**: `GET /api/user/certificate/{id}`
- **Create Certificate**: `POST /api/user/certificate`
- **Update Certificate**: `POST /api/user/certificate/{id}`
- **Delete Certificate**: `DELETE /api/user/certificate/{id}`

### Attendance Routes
- **List Attendances**: `GET /api/user/attendance`
- **Show Attendance**: `GET /api/user/attendance/{id}`
- **Create Attendance**: `POST /api/user/attendance`
- **Update Attendance**: `POST /api/user/attendance/{id}`
- **Delete Attendance**: `DELETE /api/user/attendance/{id}`
- **Approve Attendance**: `GET /api/user/attendance/approve/{id}`
- **Reject Attendance**: `GET /api/user/attendance/reject/{id}`

### Asset Routes
- **List Assets**: `GET /api/user/asset`
- **Show Asset**: `GET /api/user/asset/{id}`
- **Create Asset**: `POST /api/user/asset`
- **Update Asset**: `POST /api/user/asset/{id}`
- **Delete Asset**: `DELETE /api/user/asset/{id}`

### Dashboard Routes
- **User Dashboard**: `GET /api/user/dashboard`

## Company Routes

These routes are related to managing the company settings and notifications.

### Notification Routes
- **Send Notification**: `POST /api/company/notification/send`

### Department Routes
- **List Departments**: `GET /api/company/department`
- **Show Department**: `GET /api/company/department/{id}`
- **Create Department**: `POST /api/company/department`
- **Update Department**: `POST /api/company/department/{id}`
- **Delete Department**: `DELETE /api/company/department/{id}`

### Setting Routes
- **Get Settings**: `GET /api/company/index`
- **Update Settings**: `POST /api/company/setting`

## Lookup Routes

The following routes provide lookup data such as countries, genders, and statuses.

- **Countries**: `GET /api/lookups/countries`
- **Genders**: `GET /api/lookups/genders`
- **Regions**: `GET /api/lookups/regions`
- **Material Status**: `GET /api/lookups/material_status`
- **Work Types**: `GET /api/lookups/work_types`
- **Contract Types**: `GET /api/lookups/contract_types`
- **User Status**: `GET /api/lookups/status_user`
- **Attendance Status**: `GET /api/lookups/status_attendance`
- **Leave Reasons**: `GET /api/lookups/reason_leave`
- **Leave Status**: `GET /api/lookups/status_leave`
- **Vacation Types**: `GET /api/lookups/vacation_type`
- **Asset Types**: `GET /api/lookups/asset_type`
- **Missing Punch Types**: `GET /api/lookups/missing_punch_type`
- **Document Types**: `GET /api/lookups/document_type`

## Messages Routes

These routes are related to the message system in the project.

- **List Messages**: `GET /api/message/list`
- **Show Message**: `GET /api/message/show/{code}`
