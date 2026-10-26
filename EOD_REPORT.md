# EOD Report — SMS Project

**Date:** 25 October 2026  
**Project:** Uttara Sector 3 Welfare Society SMS and collection portal

## Work Completed

- Captured 35 authenticated screen views across the admin dashboard and its menu workflows.
- Prepared this menu-by-menu summary with the observed dashboard figures.
- Screenshot review was read-only; no resident, billing, payment, SMS, or permission records were changed.

## Dashboard Snapshot

- Today's collections: **৳0**
- Collected this month: **৳16,200**
- Outstanding balances: **৳1,029,750** across **672** bills
- Active plots and units: **6**
- Current-month bills: **808**, totaling **৳1,034,750**
- Current-month bill summary: **৳5,000 paid** and **৳1,029,750 due**

The dashboard's monthly collection card uses payment date; the bill summary uses billing month, so the figures cover different groupings.

## Menu Summary and Steps

### Dashboard
**Summary:** Current financial and operational overview.  
**Steps:** Open Dashboard → review collections, outstanding balances, active plots, and bills → check recent bills, collections, plots, and notifications.

### Plot Management
**Summary:** Resident, holding, building, and plot/unit records.  
**Steps:** Open Plot → search or filter → view, create, or edit a record → use Bulk Upload for spreadsheet imports.

### Payment Management
**My Payments:** Review payment records and receipts.  
**Steps:** Open My Payments → find a resident/holding → review payment information or open a receipt.

**Payment Report:** Review payment report data.  
**Steps:** Open Payment Report → filter or search → review the report rows.

### Collection Management
**Bill Generator:** Create monthly bills and manage dues.  
**Steps:** Open Bill Generator → select billing month and due date → generate bills → search/filter results → record payment or send reminders.

**Collections:** Review payment entries and totals.  
**Steps:** Open Collections → filter by date, method, road, or search term → inspect payment and receipt details.

**Collectors:** Review collector accounts and road assignments.  
**Steps:** Open Collectors → select a collector → assign roads → save.

### SMS Management
**Bulk SMS:** Send custom or saved messages to existing members or a custom number.  
**Steps:** Open Bulk SMS → select recipient(s) → choose custom text or a draft and language → choose send now or schedule → submit.

**Draft SMS:** Maintain reusable message templates.  
**Steps:** Open Draft SMS → search/filter → create or edit type, language, and message → save.

**SMS History:** Review logged sending attempts.  
**Steps:** Open SMS History → filter by phone/date → review the delivery status rows.

### Administration
**Activities:** Maintain activity labels. Steps: search/filter → create or edit → save.  
**Roles:** Maintain system roles. Steps: list/search → create or edit a role → save.  
**Roads:** Maintain road records. Steps: search/filter → create or edit → save.  
**Users:** Manage user accounts. Steps: search → create or edit user details → save.  
**Permissions:** Maintain permission definitions and menu access. Steps: filter/reorder → create or edit permission → save.

### Access Control
**Role Permissions:** Set shared access by role. Steps: open Role Permissions → choose a role → update allowed actions → save.  
**User Permissions:** Set account-specific access. Steps: open User Permissions → choose a user → update allowed actions → save.

### Settings
**Plot Types:** Maintain plot categories, fees, and status. Steps: open Plot Types → create/edit → activate or deactivate as needed → save.  
**Site Settings:** Update organization details, email, or password settings. Steps: open Site Settings → choose the settings section → update fields → save.  
**Profile:** Review the signed-in account profile.

## Findings

- The legacy URL `/admin/bulksms/draft-sms` points to a missing `BulkSmsController::DraftSMS` method. The Draft SMS menu itself opens `/admin/draft` and works.
- `/admin/collectors/{id}/edit` and `/admin/collectors/receipt/{id}` point to missing controller methods.
- The separate `/admin/settings` URL points to a missing `HomeController::settings` method. The Site Settings menu target `/admin/settings/edit` works.
- The member `/member/pay-dues` route currently stops at an “Under Construction” debug output.
- Menu visibility depends on user permissions.

## Screenshot Coverage

The companion Word file contains 35 captured page views: Dashboard (1), Plot Management (5), Payment Management (3), Collection Management (4), SMS Management (5), Administration (10), Access Control (2), and Settings (5).
