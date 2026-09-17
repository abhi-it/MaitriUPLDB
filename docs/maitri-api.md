# Maitri API Documentation

Base URL: `{{base_url}}/api`  
Auth: **Bearer JWT** from Maitri login  
Header: `Authorization: Bearer {{maitri_token}}`

Login uses the `maitries` table (`App\Models\Maitri`).  
Middleware: `maitri.api` (`MaitriApiAuth`)

---

## 1. Public Auth

### 1.1 Maitri Login
- **Method:** `POST`
- **URL:** `/v1/maitri-login`
- **Auth:** No

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `email` | string | Yes | Maitri email from `maitries` |
| `password` | string | Yes | Password |

**Success data:** `token`, `token_type`, `user` (+ `profileDone`)

Validation returns **first error only**.

---

## 2. Authenticated Maitri APIs

### 2.1 Dashboard
- **Method:** `GET`
- **URL:** `/auth/v1/maitri/dashboard`
- **Matches web:** `GET /maitri-dashboard`
- **Query:** `per_page`, `page` (optional)

Returns maitri profile + paginated service requests where `maitri_id` = logged-in maitri.

---

### 2.2 Dashboard Data (Animal Service Upload)
- **Method:** `POST`
- **URL:** `/auth/v1/maitri/dashboard-data`
- **Matches web:** `POST /maitri-dashdata`
- **Content-Type:** `multipart/form-data`

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `categories` | string | Yes | Category value |
| `animal_file` | file | Yes | Image max 2MB |

---

### 2.3 Request List
- **Method:** `GET`
- **URL:** `/auth/v1/maitri/request-list`
- **Matches web:** `GET /request-list`
- **Query:**

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `per_page` | int | No | Default 10 |
| `page` | int | No | Page number |
| `status` | string | No | `0` Accept, `1` New, `2` Waiting, `3` Decline |

---

### 2.4 Update Service Request Status
- **Method:** `POST`
- **URL:** `/auth/v1/maitri/update-service-request`
- **Matches web:** `POST /updateServiceRequest`

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `id` | int | Yes | Service request id |
| `status` | string | Yes* | `0/1/2/3` |
| `val` | string | Yes* | Same as web (`val`) if `status` not sent |

\* Provide either `status` or `val`.

---

### 2.5 Maitri Details
- **Method:** `GET`
- **URL:** `/auth/v1/maitri/maitri-details`
- **Matches web:** `GET /maitri-details`

Returns maitri profile + divisions/districts for edit form.

---

### 2.6 Update Maitri Details
- **Method:** `POST`
- **URL:** `/auth/v1/maitri/update-maitri-details`
- **Matches web:** `POST /update-maitri-details`

Partial update (`sometimes`) — only sent fields are updated.  
First validation error only.

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `first_name` / `maitri_name` | string | No | Name |
| `MobileNumber` / `maitri_mobile_no` | string | No | Mobile |
| `email` | string | No | Email |
| `password` + `password_confirmation` | string | No | Optional new password |
| `gender` | string | No | Gender |
| `division_id` | int | No | Mandal |
| `district_id` | int/string | No | District |
| `gram_panchayat` | string | No | Gram panchayat |
| `post_office` | string | No | Post office |
| `block` | string | No | Block |
| `tehsil` | string | No | Tehsil |
| `pincode` | string | No | Pincode |

---

### 2.7 Logout
- **Method:** `GET`
- **URL:** `/auth/v1/maitri/logout`

---

## 3. Postman

Import: `docs/Maitri_API.postman_collection.json`  
Set `base_url`, run **Maitri Login** (saves `maitri_token`), then call authenticated APIs.

## 4. Test Flow

1. `POST /v1/maitri-login`
2. `GET /auth/v1/maitri/dashboard`
3. `GET /auth/v1/maitri/request-list`
4. `POST /auth/v1/maitri/update-service-request`
5. `GET /auth/v1/maitri/maitri-details`
6. `POST /auth/v1/maitri/update-maitri-details`
7. `POST /auth/v1/maitri/dashboard-data`
8. `GET /auth/v1/maitri/logout`
