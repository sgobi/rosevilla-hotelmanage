# WhatsApp Notification Testing Guide

## 🎯 Feature Overview
When an admin approves or rejects a reservation/event booking, the customer automatically receives a WhatsApp notification with the decision.

---

## 📋 Testing Options

### Option 1: Test via Command Line (Quick Test)

#### For Reservations:
```bash
# Test approval notification
php artisan test:whatsapp-reservation 1 approved

# Test cancellation notification
php artisan test:whatsapp-reservation 1 cancelled
```

#### For Event Bookings:
```bash
# Test approval notification
php artisan test:whatsapp-event 1 approved

# Test rejection notification
php artisan test:whatsapp-event 1 rejected

# Test cancellation notification
php artisan test:whatsapp-event 1 cancelled
```

**Note:** Replace `1` with an actual reservation/event ID from your database.

---

### Option 2: Test via Admin Panel (Full Workflow)

#### Step 1: Access the Admin Panel
1. Open your browser and go to: http://127.0.0.1:8000/admin/login
2. Login with admin credentials

#### Step 2: Test Room Reservation
1. Go to **Reservations** section
2. Find a reservation with status "Pending"
3. Click to view/edit the reservation
4. Change status to "Approved" or "Cancelled"
5. Save changes
6. ✅ Customer will receive WhatsApp notification automatically!

#### Step 3: Test Event Booking
1. Go to **Event Bookings** section
2. Find an event booking with status "Pending"
3. Click to view/edit the booking
4. Change status to "Approved", "Rejected", or "Cancelled"
5. Save changes
6. ✅ Customer will receive WhatsApp notification automatically!

---

### Option 3: Create a New Test Booking

#### Create Test Reservation (Public Form):
1. Go to: http://127.0.0.1:8000
2. Navigate to "Book Now" or Rooms section
3. Fill in the booking form with:
   - **Your WhatsApp number** (for testing)
   - Guest details
   - Check-in/Check-out dates
4. Submit the form
5. Login to admin panel
6. Approve/Reject the booking
7. ✅ Check your WhatsApp for the notification!

---

## 📱 WhatsApp Message Examples

### ✅ Approved Reservation:
```
Dear John Doe,

Great news! Your reservation at Rosevilla has been APPROVED! ✅

📅 Check-in: Jan 26, 2026
📅 Check-out: Jan 28, 2026
🏨 Room: Deluxe Suite
💰 Total: LKR 25,000.00

We look forward to welcoming you to Rosevilla!
```

### ❌ Cancelled Reservation:
```
Dear John Doe,

We regret to inform you that your reservation at Rosevilla has been CANCELLED. ❌

📅 Dates: Jan 26, 2026 - Jan 28, 2026
🏨 Room: Deluxe Suite

If you have any questions, please contact us directly.

Thank you for considering Rosevilla.
```

---

## 🔧 Troubleshooting

### If WhatsApp notifications are not being sent:

1. **Check Twilio Credentials:**
   - Open `.env` file
   - Verify `TWILIO_SID`, `TWILIO_TOKEN`, and `TWILIO_WHATSAPP_FROM` are set correctly

2. **Check Phone Number Format:**
   - Phone numbers should be in format: `0771234567` or `771234567`
   - System automatically adds `+94` for Sri Lankan numbers

3. **Check Logs:**
   ```bash
   # View Laravel logs
   tail -f storage/logs/laravel.log
   ```

4. **Test Twilio Connection:**
   ```bash
   php artisan whatsapp:test
   ```

---

## 🎨 Customizing Messages

To customize the WhatsApp message content, edit these files:

- **Reservations:** `app/Notifications/WhatsAppReservationStatusUpdate.php`
- **Events:** `app/Notifications/WhatsAppEventStatusUpdate.php`

Look for the `toTwilio()` method and modify the message text.

---

## 📊 What Gets Logged

All WhatsApp notification attempts are logged. Check:
- `storage/logs/laravel.log` for errors
- Success messages appear in admin panel after status updates

---

## ✨ Features Included

✅ Automatic phone number formatting (+94 for Sri Lanka)
✅ Error handling with graceful fallback
✅ Detailed booking information in messages
✅ Support for both reservations and event bookings
✅ Admin confirmation messages
✅ Emoji-enhanced messages for better readability

---

**Ready to test? Start with Option 1 (Command Line) for the quickest test!**
