# Farmer API Documentation

Base URL: `{{base_url}}/api`  
Default local example: `http://localhost/api` or `http://127.0.0.1:8000/api`

Auth type for protected APIs: **Bearer JWT**  
Header: `Authorization: Bearer {{farmer_token}}`

Response format:

```json
{
  "message": "string",
  "status": "success | error",
  "data": {}
}
```

---

## 1. Master / Helper APIs (Public)

Use these while building signup / profile forms.

### 1.1 Mandal (Division) List
- **Method:** `GET`
- **URL:** `/v1/mandal_list`
- **Auth:** No
- **Description:** Returns all mandals/divisions for dropdown.

### 1.2 District List
- **Method:** `GET`
- **URL:** `/v1/district_list`
- **Auth:** No
- **Query params:**

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `division_id` | integer | Yes | Selected mandal/division id |

### 1.3 Tehsil List
- **Method:** `GET`
- **URL:** `/v1/tehsil_list`
- **Auth:** No
- **Query params:**

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `district_name` | string | Yes | District Hindi name (`name_hindi`) |

### 1.4 Block List
- **Method:** `GET`
- **URL:** `/v1/getAllBlock`
- **Auth:** No
- **Query params:**

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `tehsil` | string | Yes | Selected tehsil name |

### 1.5 Animal Types
- **Method:** `GET`
- **URL:** `/v1/animal_types`
- **Auth:** No
- **Description:** Returns animal type options (`cow`, `buffalo`, `goat`).

---

## 2. Farmer Auth APIs (Public)

### 2.1 Farmer Signup
- **Method:** `POST`
- **URL:** `/v1/farmer-signup`
- **Auth:** No
- **Content-Type:** `multipart/form-data` or `application/x-www-form-urlencoded` / JSON
- **Description:** Registers a farmer (same fields as web signup). Returns JWT token.

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `first_name` | string | Yes | Farmer first name |
| `last_name` | string | No | Farmer last name |
| `MobileNumber` | string | Yes | Unique mobile number |
| `email` | string | Yes | Unique email |
| `password` | string | Yes | Min 8 characters |
| `password_confirmation` | string | Yes | Must match password |
| `gender` | string | Yes | `male` / `female` / `others` |
| `division_id` | integer | Yes | Mandal id |
| `district_id` | integer/string | Yes | District id (preferred) or name |
| `tehsil` | string | Yes | Tehsil name |
| `block` | string | Yes | Vikas khand / block |
| `post_office` | string | Yes | Post office |
| `pincode` | string | Yes | Max 6 digits |
| `gram_panchayat` | string | Yes | Gram panchayat |
| `animal_type[]` | array | Yes | `cow` / `buffalo` / `goat` |
| `breeds[]` | array | Yes | Breed names |
| `cattale_no[]` | array | Yes | Cattle count |
| `milk_day[]` | array | Yes | Milk per day per animal |

**Success data:**
- `token` — JWT bearer token
- `token_type` — `bearer`
- `user` — farmer profile + animals

---

### 2.2 Farmer Login
- **Method:** `POST`
- **URL:** `/v1/farmer-login`
- **Auth:** No
- **Description:** Login with email + password. Returns JWT.

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `email` | string | Yes | Registered email |
| `password` | string | Yes | Account password |

**Success data:**
- `token`
- `token_type`
- `user` (includes `profileDone`, `checkAnimal`)

---

## 3. Farmer Authenticated APIs

Middleware: `farmer.api` (JWT must belong to `FarmerUser`)

### 3.1 Dashboard
- **Method:** `GET`
- **URL:** `/auth/v1/farmer/dashboard`
- **Auth:** Bearer token
- **Description:** Farmer dashboard with profile + service request list.

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `per_page` | integer | No | Page size (default `10`) |
| `page` | integer | No | Page number |

---

### 3.2 Get Service Request Form Data
- **Method:** `GET`
- **URL:** `/auth/v1/farmer/service-request`
- **Auth:** Bearer token
- **Description:** Returns services list, maitris in farmer district, and missing location flags.

**Success data keys:**
- `farmer`
- `missing_location`
- `can_submit`
- `services`
- `maitries`

---

### 3.3 Submit Service Request
- **Method:** `POST`
- **URL:** `/auth/v1/farmer/service-request`
- **Auth:** Bearer token
- **Description:** Creates a new service request for selected maitri.

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `services` | string | Yes | Service value (e.g. `frozen_semen_ai`) |
| `maitri_id` | integer | Yes | Must exist in `maitries` |
| `request_message` | string | Yes | Max 1500 characters |

---

### 3.4 Farmer Details
- **Method:** `GET`
- **URL:** `/auth/v1/farmer/farmer-details`
- **Auth:** Bearer token
- **Description:** Returns logged-in farmer profile, animal info, divisions and districts for edit form.

---

### 3.5 Update Farmer Details
- **Method:** `POST`
- **URL:** `/auth/v1/farmer/update-farmer-details`
- **Auth:** Bearer token
- **Description:** Updates farmer profile and animal rows (same behavior as web profile update).

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `first_name` | string | Yes | First name |
| `last_name` | string | No | Last name |
| `MobileNumber` | string | Yes | Unique except current user |
| `email` | string | No | Unique except current user |
| `password` | string | No | Min 8 if provided |
| `password_confirmation` | string | If password | Must match password |
| `gender` | string | Yes | Gender |
| `division_id` | integer | Yes | Mandal id |
| `district_id` | integer/string | Yes | District id/name |
| `tehsil` | string | No | Tehsil |
| `block` | string | No | Block |
| `post_office` | string | No | Post office |
| `pincode` | string | No | Pincode |
| `gram_panchayat` | string | No | Gram panchayat |
| `animal_type[]` | array | No | Animal types |
| `breeds[]` | array | No | Breeds |
| `cattale_no[]` | array | No | Counts |
| `milk_day[]` | array | No | Milk/day |
| `animal_id[]` | array | No | Existing animal row ids (update) |
| `removeAnimal[]` | array | No | Animal ids to delete |

---

### 3.6 Logout
- **Method:** `GET`
- **URL:** `/auth/v1/farmer/logout`
- **Auth:** Bearer token
- **Description:** Invalidates current JWT token.

---

### 3.7 High Yielding Animal List
- **Method:** `GET`
- **URL:** `/auth/v1/farmer/high-yielding-animal`
- **Auth:** Bearer token
- **Description:** Returns logged-in farmer's high yielding animal records (with `file_url`). Matches web `GET /high-yielding-animal`.

---

### 3.8 Add Yielding Animal Form Data
- **Method:** `GET`
- **URL:** `/auth/v1/farmer/add-yielding-animal`
- **Auth:** Bearer token
- **Description:** Returns animal type options and required field info. Matches web `GET /add-yielding-animal`.

---

### 3.9 Add / Update Animal Details
- **Method:** `POST`
- **URL:** `/auth/v1/farmer/add-update-animal-details`
- **Auth:** Bearer token
- **Content-Type:** `multipart/form-data`
- **Description:** Uploads animal photo and saves high yielding animal record. Matches web `POST /addUpdateAnimalDetails`.

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `type` | string | Yes | `buffalo` / `cow` / `goat` / `horse` |
| `file` | file | Yes | Image (gif,jpeg,jpg,png,svg), max 2MB |
| `details` | string | No | Description / details |

---

## 4. Postman Setup

1. Import file: `docs/Farmer_API.postman_collection.json`
2. Set collection variables:
   - `base_url` → e.g. `http://127.0.0.1:8000`
   - `farmer_token` → auto-filled from Signup/Login test scripts
3. Run **Farmer Signup** or **Farmer Login** first.
4. Then call protected APIs under **Authenticated Farmer**.

---

## 5. Suggested Test Flow

1. `GET /v1/mandal_list`
2. `GET /v1/district_list?division_id=...`
3. `GET /v1/tehsil_list?district_name=...`
4. `GET /v1/getAllBlock?tehsil=...`
5. `POST /v1/farmer-signup`
6. `GET /auth/v1/farmer/dashboard`
7. `GET /auth/v1/farmer/farmer-details`
8. `GET /auth/v1/farmer/service-request`
9. `POST /auth/v1/farmer/service-request`
10. `POST /auth/v1/farmer/update-farmer-details`
11. `GET /auth/v1/farmer/high-yielding-animal`
12. `GET /auth/v1/farmer/add-yielding-animal`
13. `POST /auth/v1/farmer/add-update-animal-details`
14. `GET /auth/v1/farmer/logout`
