# Rose Villa Heritage Homes
## Reservation & Operational Management System — User Manual

Welcome to the **Rose Villa Heritage Homes Management System**. Rose Villa is a boutique heritage hotel located in historic Jaffna, Sri Lanka, featuring colonial architecture from the 1800s and hosting a maximum of 12 guests for an intimate cultural experience.

This manual serves as a comprehensive guide for both **public customers (guests)** navigating the website and **internal hotel staff (Administrators, Reception Staff, and Accountants)** managing operations.

---

## Table of Contents
1. [Guest Portal Guide (Public Website)](#1-guest-portal-guide-public-website)
   - [Homepage Features & Exploration](#homepage-features--exploration)
   - [Language & Currency Selection](#language--currency-selection)
   - [Room Reservation Request](#room-reservation-request)
   - [Garden Booking Request](#garden-booking-request)
   - [Submitting Reviews](#submitting-reviews)
2. [Internal Dashboard & User Roles](#2-internal-dashboard--user-roles)
   - [Accessing the Dashboard](#accessing-the-dashboard)
   - [User Roles & Permissions Matrix](#user-roles--permissions-matrix)
3. [Front Desk Operations](#3-front-desk-operations)
   - [Calendar & Room List Views](#calendar--room-list-views)
   - [Room Reservation Lifecycle](#room-reservation-lifecycle)
   - [Recording Payments (Advance & Final)](#recording-payments-advance--final)
   - [Check-in & Check-out Procedures](#check-in--check-out-procedures)
   - [Operational Reset (Security Clearances)](#operational-reset-security-clearances)
4. [Event & Garden Booking Management](#4-event--garden-booking-management)
   - [Scenic Garden Bookings](#scenic-garden-bookings)
   - [Full Event Bookings (Weddings & Corporate Retreats)](#full-event-bookings-weddings--corporate-retreats)
5. [Discount Approval Workflow](#5-discount-approval-workflow)
   - [Staff Suggestions](#staff-suggestions)
   - [Administrator Approvals](#administrator-approvals)
6. [Invoicing & Reprint Security Controls](#6-invoicing--reprint-security-controls)
   - [Proforma vs. Final Invoices](#proforma-vs-final-invoices)
   - [Staff Print Restrictions & Reprint Approvals](#staff-print-restrictions--reprint-approvals)
   - [Emailing Invoices](#emailing-invoices)
7. [Website Content & Asset Management](#7-website-content--asset-management)
   - [Editing Website Content](#editing-website-content)
   - [Gallery Images](#gallery-images)
   - [Moderating Reviews](#moderating-reviews)
   - [Landmark Directory](#landmark-directory)
   - [Promotional Popups](#promotional-popups)
8. [System Maintenance & Database Security](#8-system-maintenance--database-security)
   - [Database Backups & Restores](#database-backups--restores)
   - [MySQL Database Migrations](#mysql-database-migrations)
   - [Safe Database Purging (Data Wipes)](#safe-database-purging-data-wipes)

---

## 1. Guest Portal Guide (Public Website)

Guests interact with the public portal of Rose Villa Heritage Homes to explore rooms, plan activities, and request bookings.

### Homepage Features & Exploration
The homepage is designed to give guests an immersive view of the villa:
- **Room Showcase**: Guests can view active rooms, descriptions, images, capacities, and base rates.
- **Scenic Garden**: Details about garden rental rates, features (e.g., hosting up to 1,000 guests), and custom ritual options.
- **Heritage Gallery**: Photos showcasing the 1800s architecture, gardens, and heritage spaces.
- **Local Landmarks**: Distance and walking times to attractions like Jaffna Fort, Nallur Temple, and Jaffna International Airport.
- **Verified Guest Reviews**: Authentic testimonials from past guests.
- **Promotional Popups**: Displays active promotions, seasonal events, or important announcements.

### Language & Currency Selection
To accommodate international guests, the website supports instant, session-based language and currency conversions:
- **Supported Languages**: English (`en`), French (`fr`), Hindi (`hi`), Sinhala (`si`), and Tamil (`ta`). Selecting a language updates the interface language instantly.
- **Supported Currencies**: 
  - Sri Lankan Rupee (Rs / `LKR`) — *Default*
  - US Dollar ($ / `USD`)
  - Euro (€ / `EUR`)
  - Canadian Dollar (C$ / `CAD`)
  - Indian Rupee (₹ / `INR`)
  Prices on the homepage automatically convert based on real-time conversions defined in the system.

### Room Reservation Request
Guests can request to book one or more rooms for a range of dates:
1. Scroll down to the **Booking & Availability Form** (or click "Book a Room" on any room card).
2. Choose **Room Stay** as the booking type.
3. Select one or more rooms from the room list.
4. Input the **Check-in** and **Check-out** dates.
5. Specify the total number of guests, special requirements, and any additional notes.
6. Provide guest details: Full Name, Email, Address, and Phone Number.
7. Click **Submit Booking**. If any selected room overlaps with an already approved booking, the website will display an error prompting you to choose alternative dates or rooms.
8. Upon successful submission, a message states: *"Thank you. Your reservation request has been received. Our team will confirm shortly."*

### Garden Booking Request
For photo shoots, private gatherings, or events in the villa's garden:
1. Select **Garden Rental** as the booking type on the main reservation form.
2. Select the dates for check-in and check-out.
3. Provide guest details, estimated guest count, and specific setup requirements.
4. Click **Submit Booking**. Overlapping bookings are blocked, prompting the guest to adjust their dates.

### Submitting Reviews
Guests can share their experience directly on the website:
1. Click the **Write a Review** button in the Testimonials section.
2. Enter your Name, select a Rating (1 to 5 stars), and write your Comment.
3. Click **Submit Review**. Reviews are auto-published onto the website immediately, but can be moderated by Administrators later.

---

## 2. Internal Dashboard & User Roles

Internal hotel personnel use the administrative dashboard to handle bookings, manage check-ins/check-outs, adjust pricing, view reports, and configure site content.

### Accessing the Dashboard
- Navigate to `/login` and sign in with your corporate email and password.
- If you forget your password, click **Forgot Password** to receive a reset link in your email.
- You can manage your profile details, change your password, or delete your account at `/profile`.

### User Roles & Permissions Matrix
The system assigns specific operations based on user roles:

| Feature / Operation | Staff (Reception) | Accountant | Administrator |
| :--- | :---: | :---: | :---: |
| View Dashboard & Bookings | Yes | Yes | Yes |
| Perform Check-in & Check-out | Yes | Yes | Yes |
| Record Payments (Advance/Final) | Yes | Yes | Yes |
| Suggest Discounts | Yes (Pending Admin) | Yes (Pending Admin) | Yes (Auto-Applies) |
| Approve / Reject Discounts | No | No | Yes |
| Print Initial Invoices | Yes | Yes | Yes |
| Reprint Invoices | No (Requires Admin approval) | Yes (Unrestricted) | Yes (Unrestricted) |
| Approve Invoice Reprint Requests | No | No | Yes |
| Edit Site Content & Media | No | No | Yes |
| Run Database Backups | No | No | Yes |
| Restore Backups / Import Dumps | No | No | Yes |
| Wipe Transactional Data | No | No | Yes (Password required) |
| Operational Reset (Payments/Status) | No | Yes (Password required) | Yes (Password required) |

---

## 3. Front Desk Operations

The Front Desk is the nerve center of hotel operations. Staff manage guest arrivals, payment records, and room statuses in real-time.

### Calendar & Room List Views
- **List View (`admin/front-desk`)**: Displays all room reservations arriving today, departing today, or currently active in-house. A search bar is available to quickly lookup guests by name, phone, or email.
- **Calendar View (`admin/front-desk-calendar`)**: A color-coded calendar visualizing room stays, garden rentals, and event bookings:
  - **Red**: Pending reservation requests (require confirmation).
  - **Blue**: Approved future room bookings.
  - **Amber**: Expected arrivals today.
  - **Green**: Currently In-House.
  - **Gray**: Completed and checked out.

### Room Reservation Lifecycle
A reservation transitions through the following statuses:
```
[Pending Request] ---> [Approved Booking] ---> [In-House] ---> [Completed]
      |                       |
      v                       v
[Rejected]               [Cancelled]
```
- **Pending**: New requests submitted by guests.
- **Approved**: Staff confirms room availability and approves the request. Rooms are now officially blocked for those dates.
- **Cancelled/Rejected**: Cancelled bookings can include a cancellation reason. Staff cannot cancel approved bookings directly; they must click **Request Status Change** to notify the Admin.

### Recording Payments (Advance & Final)
To ensure strict financial reconciliation, payments are divided into two phases:
1. **Advance Payment**:
   - Must be recorded before check-in is permitted.
   - Click **Record Advance** on the reservation details panel.
   - Enter the advance amount, payment method (Bank Transfer or Cash), payer's guest name, NIC (National Identity Card) number, bank name, and bank branch.
   - Once submitted, the status updates with the timestamp of the advance payment.
2. **Final Payment**:
   - Must be recorded at checkout to clear the remaining balance.
   - Click **Record Final Payment** on the reservation.
   - Enter the payment amount, method (Bank Transfer or Cash), guest name, NIC number, and bank details.
   - Once recorded, the final invoice is cleared.

### Check-in & Check-out Procedures
- **Checking In**:
  - Allowed only after the **Advance Payment** has been successfully recorded.
  - Click the green **Check In** button. The system logs the exact check-in timestamp (`checked_in_at`).
- **Checking Out**:
  - Allowed only after the **Final Payment** has been recorded.
  - Click the red **Check Out** button. The system logs the checkout timestamp (`checked_out_at`) and marks the stay as completed.

### Operational Reset (Security Clearances)
If a mistake is made during check-in or checkout, or if payment records need to be adjusted:
- Only **Administrators** and **Accountants** have the clearance to reset operational data.
- Open the reservation and click **Reset Operations**.
- You must enter your account password to authorize the reset.
- This will clear the check-in/out timestamps, advance/final payment records, and print counts, returning the booking to an approved status for corrections.

---

## 4. Event & Garden Booking Management

In addition to room bookings, Rose Villa hosts events and garden activities.

### Scenic Garden Bookings
Garden rentals are managed at `admin/garden-bookings`:
- **Status Transitions**: Pending → Approved → Checked In → Checked Out → Completed (or Cancelled/Rejected).
- **Security Check**: The system validates garden availability before approving. If there is another approved event on the requested dates, approval is blocked.
- **Discounts**: Staff can suggest garden rental discounts. Administrators must approve them.
- **Operational actions**: Standard creation, edits, and deletions (deleting a booking requires password verification).

### Full Event Bookings (Weddings & Corporate Retreats)
Events are managed at `admin/events` and their front-desk tracking is under `admin/event-front-desk`:
- An Event Booking can reserve multiple rooms, the scenic garden, or both.
- **Workflow**:
  1. Record the Event details (customer name, email, phone, event date, start/end times).
  2. Select rooms and/or garden options.
  3. Record the **Advance Payment** (authorizes starting the event).
  4. Start the event (Check In).
  5. Record the **Final Payment** (authorizes completing the event).
  6. Complete the event (Check Out).

---

## 5. Discount Approval Workflow

To prevent unauthorized price modifications while allowing marketing flexibility, discounts go through a strict verification flow.

### Staff Suggestions
1. Staff opens a reservation and finds the **Discount** section.
2. Input a suggested discount percentage (0% to 100%) and click **Suggest Discount**.
3. The discount status changes to **Pending Approval**, and the discount is **NOT** yet applied.
4. An automated notification is sent to all system Administrators.

### Administrator Approvals
1. An Administrator logs in and opens the reservation details page.
2. In the discount panel, the Admin sees the suggested percentage.
3. The Admin clicks **Approve** or **Reject**:
   - **Approve**: The discount status updates to **Approved**, and the discount is automatically applied to the total price (before tax calculation). Staff are notified of the decision.
   - **Reject**: The discount status updates to **Rejected**, and the rate returns to standard pricing.

---

## 6. Invoicing & Reprint Security Controls

The invoicing module has strict safeguards to prevent invoice tampering and unauthorized reprints.

### Proforma vs. Final Invoices
- **Proforma Invoice**: 
  - A preliminary bill or quote showing estimated costs, taxes, and suggested discounts.
  - Can be generated at any time (even when the reservation is still Pending).
  - Has no printing limits or role restrictions.
- **Final Invoice**:
  - The formal, binding financial bill.
  - Can only be generated and viewed for **Approved** reservations.

### Staff Print Restrictions & Reprint Approvals
To avoid duplicate invoicing:
- **Staff Accounts** can print/view a Final Invoice **exactly once**.
- Subsequent views or prints by Staff result in a `403 Access Denied` error.
- If a reprint is needed (e.g., printer jammed, guest lost the copy):
  1. The Staff member must click **Request Reprint Approval** on the reservation page.
  2. This triggers a notification to Administrators.
  3. An **Administrator** opens the reservation and clicks **Approve Reprint** (or **Reject Reprint**).
  4. Once approved, the Staff member is authorized to print/view the invoice **one more time**. Upon printing, the permission is consumed.
- **Administrators** and **Accountants** have unrestricted reprint access and are never blocked by print counts.

### Emailing Invoices
Staff can email invoices directly to guests:
- Click **Send Invoice via Email** on the invoice view.
- Verify the recipient's email (pre-filled with the guest's contact email) and click **Send**.
- An HTML invoice is dispatched to the guest's inbox.

---

## 7. Website Content & Asset Management

Administrators can update public website copy, manage images, moderate reviews, and configure landmarks without modifying code.

### Editing Website Content
- Navigate to `admin/content`.
- Modify homepage titles, paragraphs, descriptions, or contact information.
- Configure global tax percentages (e.g. `tax_percentage`) which auto-calculates across all reservation checkouts.
- Click **Save Content** to update the website instantly.

### Gallery Images
- Navigate to `admin/gallery` to upload photos of the property, garden, or events.
- Mark specific photos as **Featured** to display them on the homepage's prominent slides.
- Edit descriptions or delete outdated images.

### Moderating Reviews
- Navigate to `admin/reviews`.
- See a list of all reviews submitted by guests.
- Toggle the **Published** status to display or hide specific reviews on the public site.

### Landmark Directory
- Navigate to `admin/landmarks`.
- Add local attractions in Jaffna (e.g., temples, historic ruins, beaches).
- Specify their distance in kilometers, name, description, and directions.
- These display dynamically in the attractions section of the homepage.

### Promotional Popups
- Navigate to `admin/popups` to manage modal windows.
- Create promotional popups (e.g., *"30% Off Winter Retreats"*).
- Upload an image, add a call-to-action button link, and toggle **Is Active** to display it to visitors when they first load the homepage. Only one popup can be active at a time.

---

## 8. System Maintenance & Database Security

Administrators have access to database maintenance utilities under `admin/maintenance` to safeguard hotel information.

### Database Backups & Restores
- **Downloading Backups**:
  - Click **Download Backup** to instantly download the current SQLite database (`database.sqlite`) to your local machine as a `.sqlite` file.
- **Restoring Backups**:
  - Upload a previously downloaded `.sqlite` file.
  - Enter your Administrator password to authenticate.
  - The system makes a recovery backup of the current database, and then replaces the live database file with the uploaded state.

### MySQL Database Migrations
If Rose Villa updates its infrastructure to use a dedicated MySQL server:
- **Exporting MySQL Dump**:
  - Click **Export to MySQL**.
  - The system translates the SQLite tables and records into a MySQL-compatible `.sql` SQL dump file.
- **Importing MySQL Dump**:
  - Upload a `.sql` file, enter your password, and click **Import**.
  - The system will execute the statements to import database records.

### Safe Database Purging (Data Wipes)
For testing cycles or seasonal resets:
- Administrators can wipe specific transactional data categories:
  - **Room Stays** (deletes room reservation records).
  - **General Events** (deletes event booking records).
  - **Garden Bookings** (deletes garden rental records).
- To execute:
  1. Go to `admin/maintenance`.
  2. Select the categories you wish to purge.
  3. Enter your Administrator account password.
  4. Click **Wipe Selected Data**. The system will auto-backup the database before purging and delete the selected records along with system notifications.
