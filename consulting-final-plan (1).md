# Consulting by Day — চূড়ান্ত Architecture ও Task List

## Status Map (সম্পূর্ণ)

### Contract Status (আমাদের Custom)
| Status Key | UI Label | কখন হয় |
|---|---|---|
| `consulting-active` | 🟢 Active | Cycle চলছে, vendor কাজ করছে |
| `consulting-waiting-payment` | 💳 Waiting Payment | Client next cycle pay করেনি |
| `consulting-waiting-vendor` | ⏳ Waiting Vendor | Payment হয়েছে, vendor start করেনি |
| `consulting-completed` | ✅ Completed | সব cycle শেষ, সব accepted |
| `consulting-cancelled` | ❌ Cancelled | যেকোনো সময় cancel |

### WSS Order Status (Plugin-এর, per-cycle order-এ)
| Status Key | Display Name | কখন হয় |
|---|---|---|
| `wbcom_wss_waiting_for_requirement` | Waiting for Requirement | Skip (consulting-এ নেই) |
| `wbcom_wss_work_in_progress` | Work in Progress | Vendor start করলে |
| `wbcom_wss_waiting_for_approval` | Waiting for Approval | Vendor final delivery পাঠালে |
| `wbcom_wss_waiting_for_review` | Waiting for Review | Client accept করলে |
| `wbcom_wss_order_complete` | Order Complete | Order complete হলে |

### WSS Widget Timeline Status (Right Sidebar-এ)
| Key | Label | Consulting-এ ব্যবহার |
|---|---|---|
| `wss_placed_order` | Placed Order | ✅ হ্যাঁ |
| `wss_provide_requirements` | Provided Requirements | ❌ Skip |
| `wss_order_inprocess` | Order in Progress | ✅ হ্যাঁ |
| `wss_approve_delivery` | Approve Final Delivery | ✅ হ্যাঁ |
| `wss_order_complete` | Order Completed | ✅ হ্যাঁ |
| `wss_review_delivery` | Review the Delivery | ✅ হ্যাঁ |

### WooCommerce Order Status (per-cycle order)
| Status | কখন |
|---|---|
| `pending` | Child order তৈরি, payment নেই |
| `processing` | Trustap deposit paid |
| `completed` | Client accepts delivery → auto |

---

## UI-তে Status কোথায় কীভাবে দেখাবে

### Contract Page `/consulting-contract/C100` — Header Badge
```
Contract #C100                    [🟢 Active — Month 2 of 3]
```
Contract status badge সবসময় header-এ দেখাবে।

### Notice Board Card — Cycle Timeline
```
📅 Consulting Progress
─────────────────────────────────────────
✅ Month 1 — Completed & Accepted
   Jun 1–30 · 10 days · $100 released
─────────────────────────────────────────
🔄 Month 2 — Active [WSS: Work in Progress]
   Jul 1–31 · 6/10 days logged
   [View Session Log]
─────────────────────────────────────────
⏳ Month 3 — Pending Payment
   [Pay $100 for Month 3]        ← Client
   [📧 Resend Payment Link]      ← Vendor/Admin
─────────────────────────────────────────
```

### Right Sidebar Status Panel — WSS Widget (per cycle)
```
Month 2 Progress
─────────────────
[✓] Placed Order
[✓] Order in Progress     ← current
[ ] Approve Final Delivery
[ ] Order Completed
[ ] Review the Delivery
```
`wss_provide_requirements` step consulting-এ filter দিয়ে remove করা হবে।

### WCFM Services List — Extra Column
```
| Contract | Cycle | Contract Status | Cycle Status |
| C100     | 2/3   | 🟢 Active      | In Progress  |
```

---

## Database Schema (Final)

```sql
-- Table 1: Contracts
CREATE TABLE wp_consulting_contracts (
  id               BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  contract_number  VARCHAR(50)  NOT NULL,        -- C1001
  cpt_post_id      BIGINT(20)   NOT NULL,         -- CPT post ID
  client_id        BIGINT(20)   NOT NULL,
  vendor_id        BIGINT(20)   NOT NULL,
  product_id       BIGINT(20)   NOT NULL,
  first_order_id   BIGINT(20)   NOT NULL,         -- WSS chat reference (always)
  wss_item_id      BIGINT(20)   NOT NULL,         -- WC order item ID for WSS
  consulting_type  VARCHAR(10)  NOT NULL,         -- 'days' or 'hours'
  units_per_cycle  INT(11)      NOT NULL,         -- 10
  total_cycles     INT(11)      NOT NULL,         -- 3
  current_cycle    INT(11)      NOT NULL DEFAULT 1,
  cycle_price      DECIMAL(10,2) NOT NULL,        -- 100.00
  status           VARCHAR(50)  NOT NULL DEFAULT 'consulting-active',
  created_at       DATETIME     NOT NULL,
  updated_at       DATETIME     NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY contract_number (contract_number),
  KEY cpt_post_id (cpt_post_id),
  KEY client_id (client_id),
  KEY vendor_id (vendor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table 2: Cycles
CREATE TABLE wp_consulting_cycles (
  id               BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  contract_id      BIGINT(20)   NOT NULL,
  cycle_no         INT(11)      NOT NULL,         -- 1, 2, 3
  order_id         BIGINT(20)   NOT NULL,         -- WC Order ID
  wss_item_id      BIGINT(20)   NOT NULL,         -- WC order item ID
  trustap_txn_id   VARCHAR(200) DEFAULT NULL,
  trustap_buyer_id VARCHAR(200) DEFAULT NULL,     -- saved at first order
  amount           DECIMAL(10,2) NOT NULL,
  status           VARCHAR(50)  NOT NULL DEFAULT 'pending',
  -- pending | waiting-payment | active | delivered | accepted | rejected
  units_target     INT(11)      NOT NULL,
  units_logged     DECIMAL(8,2) NOT NULL DEFAULT 0,
  started_at       DATETIME     DEFAULT NULL,
  delivered_at     DATETIME     DEFAULT NULL,
  accepted_at      DATETIME     DEFAULT NULL,
  PRIMARY KEY (id),
  KEY contract_id (contract_id),
  KEY order_id (order_id),
  KEY status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table 3: Session Logs
CREATE TABLE wp_consulting_logs (
  id               BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  contract_id      BIGINT(20)   NOT NULL,
  cycle_id         BIGINT(20)   NOT NULL,
  vendor_id        BIGINT(20)   NOT NULL,
  log_date         DATE         NOT NULL,
  units_logged     DECIMAL(5,2) NOT NULL,         -- hours or days
  note             TEXT         DEFAULT NULL,
  created_at       DATETIME     NOT NULL,
  PRIMARY KEY (id),
  KEY cycle_id (cycle_id),
  KEY contract_id (contract_id),
  KEY log_date (log_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## File Structure

```
child-theme/
├── functions.php                          ← main loader
└── inc/
    └── consulting/
        ├── class-consulting-db.php        ← table install + CRUD
        ├── class-consulting-cpt.php       ← CPT + permalink
        ├── class-consulting-product.php   ← WCFM product fields
        ├── class-consulting-cart.php      ← cart/checkout/order meta
        ├── class-consulting-contract.php  ← contract create/advance
        ├── class-consulting-cycle.php     ← cycle CRUD + next cycle
        ├── class-consulting-trustap.php   ← Trustap API wrapper
        ├── class-consulting-email.php     ← all email notifications
        ├── class-consulting-wss.php       ← WSS status filter/override
        └── views/
            ├── contract-page.php          ← full contract page template
            ├── notice-board.php           ← cycle timeline card
            ├── session-log.php            ← vendor log card
            └── status-panel.php           ← right sidebar widget
```

---

## Complete Task List

### Phase 1 — Foundation (DB + CPT + Product)

#### TASK-001: DB Table Installation
- `class-consulting-db.php` তৈরি
- `register_activation_hook` বা `plugins_loaded`-এ `dbDelta()` দিয়ে ৩টি table তৈরি
- Version check দিয়ে upgrade safe করা
- CRUD methods: `insert_contract()`, `get_contract()`, `update_contract()`, `insert_cycle()`, `get_cycle()`, `update_cycle()`, `insert_log()`, `get_logs_by_cycle()`

#### TASK-002: CPT Registration
- `class-consulting-cpt.php`-এ `consulting_contract` CPT register
- Permalink: `/consulting-contract/{contract_number}` (slug = contract_number, C1001)
- Custom capabilities: client ও vendor শুধু নিজের contract দেখতে পারবে
- Admin list view-এ Contract#, Client, Vendor, Status, Cycle column

#### TASK-003: WCFM Product Fields
- `class-consulting-product.php`
- `wcfm_product_manage_fields_general` filter-এ "Consulting Service" checkbox যোগ
- JS দিয়ে checkbox checked হলে consulting config section show
- Fields: Billing Type (days/hours), Price per Unit, Min Qty, Max Qty, Max Months
- `after_wcfm_products_manage_meta_save` action-এ save: `_consulting_enabled`, `_consulting_type`, `_consulting_rate`, `_consulting_min_qty`, `_consulting_max_qty`, `_consulting_max_months`
- WooCommerce native product tab-এও same fields (admin)

---

### Phase 2 — Product Page & Cart

#### TASK-004: Single Product Page UI
- `class-consulting-cart.php`
- `woocommerce_before_add_to_cart_button` hook-এ consulting UI inject
- Fields: Units/month selector (min–max range), Months dropdown (1 to max_months)
- Live price calculation JS: `units × rate = monthly`, `monthly × months = total`
- Summary box: Monthly $X · Total $Y · Pay today $Z
- Add to cart button text override: "Start Consulting — Pay $Z"

#### TASK-005: Cart & Checkout Data
- `woocommerce_add_cart_item_data` — cart meta save
- `woocommerce_get_item_data` — cart/checkout-এ display
- Cart total = cycle_price only (Month 1)
- `woocommerce_checkout_create_order_line_item` — order item meta save
- `woocommerce_admin_order_item_headers` + `woocommerce_admin_order_item_values` — WC admin order view
- Save `trustap_buyer_id` from WC session to order meta at `woocommerce_checkout_order_created`

#### TASK-006: Checkout Price Enforcement
- `woocommerce_before_calculate_totals` — force cart total = cycle_price
- Prevent any coupon/discount applying to full contract amount

---

### Phase 3 — Contract Creation

#### TASK-007: Contract Create on Payment
- `class-consulting-contract.php`
- Hook: `woocommerce_payment_complete` (priority 5)
- Check: order has consulting item?
- `wp_insert_post()` → consulting_contract CPT (title = contract_number)
- `wp_consulting_contracts` insert
- `wp_consulting_cycles` insert (cycle 1, status=active)
- Save to order meta: `_consulting_contract_id`, `_consulting_cycle_id`, `_consulting_cycle_no`
- WSS status set: `wbcom_wss_work_in_progress` (requirement step skip)
- `WOO_SELL_SERVICE_CUSTOMER_REQUIREMENT_SAVE` = 'auto_skipped' (same as downloadable)

#### TASK-008: Redirect After Payment
- `wss_custom_thankyou_redirect` override (existing)
- Consulting order হলে redirect to `/consulting-contract/{contract_number}`

---

### Phase 4 — Contract Page

#### TASK-009: Contract Page Template
- `views/contract-page.php`
- Access control: client_id বা vendor_id match না হলে 404
- Admin সবকিছু দেখতে পারবে
- Two-column layout: left=chat, right=sidebar cards
- Load WSS chat with `first_order_id` (always)

#### TASK-010: Notice Board Card
- `views/notice-board.php`
- Contract info header: type, units/month, price/month
- Cycle timeline (loop through all cycles):
  - ✅ Completed cycles: date, units, amount released
  - 🔄 Active cycle: progress bar (units_logged/units_target)
  - 💳 Waiting payment: Pay button (client) + Resend link button (vendor/admin)
  - ⏳ Future cycles: greyed out
- Resend Payment Link button → AJAX → regenerate Trustap URL → email

#### TASK-011: Vendor Session Log Card
- `views/session-log.php`
- Vendor-only (hidden for client)
- Active cycle হলে log form show
- Form: date picker, units input, note textarea, [+ Add Session]
- Log list: date, units, note, [×] remove
- Progress: `units_logged / units_target` (6/10 days)
- [Send Final Delivery] button — active only when units_logged >= units_target
- Waiting-payment cycle-এ form disabled + message "Waiting for client payment"

#### TASK-012: Right Sidebar Status Panel
- `views/status-panel.php`
- Consulting-এর জন্য আলাদা render (consulting flag check)
- `wss_service_widget_statuses` filter দিয়ে `wss_provide_requirements` remove
- Active cycle-এর WSS status show করবে
- উপরে cycle indicator: "Month 2 of 3"

---

### Phase 5 — Work Log System

#### TASK-013: Log Save AJAX
- `wp_ajax_consulting_add_log`
- Validate: cycle active? vendor matches? date valid? units within range?
- `wp_consulting_logs` insert
- `wp_consulting_cycles` → `units_logged` update
- Return: updated total, progress percentage

#### TASK-014: Log Delete AJAX
- `wp_ajax_consulting_delete_log`
- Validate ownership
- Delete row, recalculate `units_logged`

---

### Phase 6 — Delivery System

#### TASK-015: Send Final Delivery
- `wp_ajax_consulting_send_final_delivery`
- Validate: cycle active, units_logged >= units_target
- Build session summary message (date-by-date log)
- `wss_dl_auto_final_delivery`-এর মতো WSS message insert
- Mark as `WOO_FINAL_DELIVERY_{msg_id}`
- WSS status → `wbcom_wss_waiting_for_approval`
- `wp_consulting_cycles` → status = 'delivered', delivered_at = NOW()
- Contract status → 'consulting-active' (unchanged, waiting for accept)

#### TASK-016: Accept Delivery Hook
- `wss_accept_final_delivery` hook (existing)
- Consulting order? Check `_consulting_contract_id` meta
- If yes:
  1. `wp_consulting_cycles` → status = 'accepted', accepted_at = NOW()
  2. Order → `completed` (Trustap auto-releases, WCFM commission auto)
  3. Check: `current_cycle < total_cycles`?
     - YES → `consulting_advance_to_next_cycle()`
     - NO → `consulting_finish_contract()`

#### TASK-017: Reject Delivery Hook
- `wss_reject_final_delivery` hook (existing)
- `wp_consulting_cycles` → status = 'active' (back to work)
- WSS status → `wbcom_wss_work_in_progress`
- Vendor notification email

---

### Phase 7 — Cycle Automation

#### TASK-018: Advance to Next Cycle
- `class-consulting-cycle.php` → `consulting_advance_to_next_cycle($contract_id)`
- `wp_consulting_contracts` → current_cycle++, status = 'consulting-waiting-payment', updated_at
- Create WC Order for next cycle:
  - `wc_create_order()` with same product, client, amount
  - Copy consulting meta from first order
  - Status: pending
  - Save `_consulting_contract_id`, `_consulting_cycle_no`
  - Save `trustap_buyer_id` (from contracts table first order meta)
- `consulting_create_trustap_transaction($child_order_id)`
- `wp_consulting_cycles` insert (new row, status='waiting-payment')
- Send payment email to client

#### TASK-019: Trustap Transaction Create
- `class-consulting-trustap.php`
- Reuse plugin's `AbstractController` via instantiation
- `POST p2p/me/transactions/create_with_guest_user`
  - seller_id from options
  - buyer_id from saved trustap_buyer_id
  - amount = cycle_price in cents
  - description = "Contract #{C1001} — Month {N}"
  - category = সার্ভিসের মতো same
- Save transaction_id to: child order meta + `wp_consulting_cycles`
- Build payment URL: `{action_url}/f2f/transactions/{txn_id}/pay_deposit?redirect_uri={webhook}`

#### TASK-020: Payment Received (Trustap Webhook)
- Trustap webhook already fires on existing WC order
- `woocommerce_order_status_changed` → pending → processing
- Check `_consulting_contract_id` meta
- `wp_consulting_cycles` → status = 'active', started_at = NOW()
- `wp_consulting_contracts` → status = 'consulting-waiting-vendor', updated_at
- Vendor email: "Month N payment received. Start sessions."

#### TASK-021: Vendor Acknowledges / Starts Cycle
- `wp_ajax_consulting_vendor_start_cycle`
- `wp_consulting_contracts` → status = 'consulting-active'
- WSS status → `wbcom_wss_work_in_progress`
- Client notification: "Your consultant has started Month N"

#### TASK-022: Contract Finish
- `consulting_finish_contract($contract_id)`
- `wp_consulting_contracts` → status = 'consulting-completed', updated_at
- CPT post → custom status 'consulting-completed'
- Completion email to both parties

---

### Phase 8 — Notifications (All Emails)

#### TASK-023: Email Templates
- `class-consulting-email.php`
- E-001: Contract Created (client + vendor)
- E-002: Payment Required — Next Cycle (client, with Pay button)
- E-003: Payment Received (vendor, start sessions)
- E-004: Delivery Submitted (client, review request)
- E-005: Delivery Accepted (vendor, payment release note)
- E-006: Revision Requested (vendor)
- E-007: Contract Completed (client + vendor)
- E-008: Payment Link Resend (client, from manual resend button)

---

### Phase 9 — WSS Integration Fixes

#### TASK-024: Skip Requirement Form
- Consulting order-এ `WOO_SELL_SERVICE_CUSTOMER_REQUIREMENT_SAVE` = 'auto_skipped'
- `woocommerce_order_item_meta_get` filter (existing downloadable fix already handles this)

#### TASK-025: Status Panel Filter
- `wss_service_widget_statuses` filter
- Consulting order হলে `wss_provide_requirements` step remove
- Cycle number indicator inject

#### TASK-026: WSS Chat Always Uses First Order
- Contract page WSS include করার সময় `$_GET['wss-orderid']` = `first_order_id`
- `$_GET['wss-itemid']` = `wss_item_id` (first order-এর item)
- প্রতিটি cycle-এ same chat thread

#### TASK-027: Block Order Auto-Complete for Consulting
- Consulting child order-এ WSS-এর `woo_sell_redirect_single_services` block
- WSS service page redirect → contract page redirect করা

---

### Phase 10 — WCFM Dashboard Integration

#### TASK-028: WCFM Services List — Consulting Column
- `services-list.php`-এ consulting contract badge যোগ
- Contract#, Cycle N/Total, Contract Status দেখাবে

#### TASK-029: Contract Detail in WCFM
- `woodmart_child_wcfm_services_load_views` → `consulting-contract` endpoint
- Contract page-এর same content WCFM-এর ভেতরে দেখাবে

#### TASK-030: Admin Tools
- Admin: সব contract দেখা
- Manual payment link resend
- Force cycle advance (override)
- Contract cancel with reason

---

### Phase 11 — Testing Checklist

#### TASK-031: End-to-End Test Scenarios
- [ ] Normal purchase → contract তৈরি → redirect ✓
- [ ] Vendor adds 10 log entries → send delivery ✓
- [ ] Client accepts → order complete → Trustap release ✓
- [ ] Next cycle order তৈরি → Trustap transaction create ✓
- [ ] Client pays next cycle → vendor notification ✓
- [ ] All 3 cycles complete → contract finished ✓
- [ ] Client rejects → vendor re-submits ✓
- [ ] Admin resends payment link ✓
- [ ] WCFM commission per-order correct ✓
- [ ] WSS chat single thread across all cycles ✓
- [ ] Trustap auto-release on order complete ✓
- [ ] Status panel shows correct cycle info ✓

---

## Coding Start Order (Recommended)

```
TASK-001 → TASK-002 → TASK-003 → TASK-004 → TASK-005 →
TASK-006 → TASK-007 → TASK-008 → TASK-009 → TASK-010 →
TASK-011 → TASK-012 → TASK-013 → TASK-014 → TASK-015 →
TASK-016 → TASK-017 → TASK-018 → TASK-019 → TASK-020 →
TASK-021 → TASK-022 → TASK-023 → TASK-024 → TASK-025 →
TASK-026 → TASK-027 → TASK-028 → TASK-029 → TASK-030 →
TASK-031
```

Foundation first (DB/CPT/Product), then Purchase Flow, then Contract + Cycle logic, then Delivery + Automation, then Notifications, then UI polish.

---

# 🆕 UPDATE — Digital Contract Pre-Confirmation Step (spa.php-inspired)

## নতুন Contract Status: `consulting-pending-confirmation`

এটা পুরো flow-এর **সবার আগে** বসবে — Payment হওয়ার পর কিন্তু কোনো cycle "active" হওয়ার আগে।

```
Payment Complete
        ↓
consulting-pending-confirmation   ← 🆕 নতুন প্রথম step (Digital Contract)
        ↓
consulting-active → consulting-waiting-payment → consulting-waiting-vendor → consulting-completed
```

---

## কোন কোন Document/Pillar রাখবো (spa.php থেকে adapt করা)

spa.php-এর ৬টা pillar থেকে **৪টা মূল pillar** আমাদের জন্য দরকার। সম্পূর্ণ ৬টা (Secure Links, Task Comments modal ইত্যাদি বাদ) আমাদের consulting-এর জন্য প্রয়োজন নেই কারণ session log আর WSS chat already সেই কাজ করে।

### Pillar 1 — NDA (Non-Disclosure Agreement)
- Editable text যতক্ষণ না কেউ sign করে
- একজন sign করলে field locked (readonly) হয়ে যায়
- দুজনেই sign করলে 🟢, একজন করলে 🟡, কেউ না করলে 🔴

### Pillar 2 — Terms & Conditions (Service-specific)
- Vendor-এর consulting service-এর জন্য নিজস্ব terms লিখতে পারে
- Same edit→lock pattern

### Pillar 3 — NCA (Platform Non-Circumvention)
- **Fixed legal text** (admin pছ থেকে site-wide একটাই, editable না)
- শুধু "Agree & Sign" বাটন — platform-এর বাইরে deal না করার commitment
- এটা legally protect করে marketplace-কে

### Pillar 4 — Scope of Work (সবচেয়ে গুরুত্বপূর্ণ — Consulting-specific)
- **Vendor লিখবে**: exact scope, কী কী deliverable, কীভাবে কাজ হবে
- কিন্তু এখানে আমরা **automatically pre-fill** করবো contract data থেকে:
  ```
  Auto-generated Scope Summary:
  ─────────────────────────────
  Consulting Type: Days
  Units per Month: 10 days
  Rate: $10/day
  Total Months: 3
  Monthly Amount: $100
  Total Contract Value: $300
  ─────────────────────────────
  [Vendor can add additional notes below]
  ```
- Vendor চাইলে extra detail add করতে পারবে, কিন্তু core numbers automatically আসবে contract table থেকে — কোনো manual mismatch হবে না

### ❌ যা বাদ দিচ্ছি (দরকার নেই)
- Secure Access Links pillar — আমাদের file sharing already WSS chat attachment দিয়ে হয়
- Task/Deliverables table with comments modal — আমাদের Session Log card + WSS chat already এই কাজ করে
- Print stylesheet — ভবিষ্যতে দরকার হলে যুক্ত করা যাবে, এখন নয়

---

## Waterfall Lock Logic (spa.php থেকে exact pattern নেওয়া)

```php
$nda_locked = ($nda_vendor_signed && $nda_client_signed);
$tnc_locked = ($tnc_vendor_signed && $tnc_client_signed);
$nca_locked = ($nca_vendor_signed && $nca_client_signed);
$sow_locked = ($sow_vendor_signed && $sow_client_signed);

$legal_signed          = ($nda_locked && $tnc_locked && $nca_locked);
$contract_fully_signed = ($legal_signed && $sow_locked);

// সব ৪টা locked হলেই → contract status: consulting-active (cycle 1 শুরু)
if ( $contract_fully_signed ) {
    consulting_activate_first_cycle( $contract_id );
}
```

**SOW (Scope of Work) sign করার বাটন NDA+TNC+NCA সব locked না হওয়া পর্যন্ত hidden থাকবে** — এটাই spa.php-এর exact waterfall pattern, আমরা সেইটাই রাখবো।

---

## UI — Contract Page-এ কীভাবে দেখাবে

```
┌──────────────────────────────────────────────────────┐
│  📝 Digital Contract — Confirmation Required          │
│  Contract #C100 · Status: 🔒 Pending Signatures       │
│  ──────────────────────────────────────────────────  │
│  ▼ 01  Non-Disclosure Agreement (NDA)            🟡  │
│       Vendor: ✅ Signed June 23, 2026 @ 3:45 PM      │
│       Client: ⏳ [Sign NDA]                           │
│  ──────────────────────────────────────────────────  │
│  ▶ 02  Terms & Conditions                        🔴  │
│  ──────────────────────────────────────────────────  │
│  ▶ 03  Platform Non-Circumvention (NCA)          🔴  │
│  ──────────────────────────────────────────────────  │
│  ▶ 04  Scope of Work                             🔒  │
│       (Locked until 01, 02, 03 fully signed)         │
└──────────────────────────────────────────────────────┘
```

সব ৪টা 🟢 হলে status badge পরিবর্তন হয়ে যাবে:
```
Status: 🟢 Active — Month 1 of 3
```
এবং Notice Board + Session Log card automatically unlock হবে।

---

## Database Changes

`wp_consulting_contracts` table-এ নতুন columns:

```sql
ALTER TABLE wp_consulting_contracts ADD COLUMN
  nda_vendor_signed_at  DATETIME DEFAULT NULL,
  nda_client_signed_at  DATETIME DEFAULT NULL,
  tnc_vendor_signed_at  DATETIME DEFAULT NULL,
  tnc_client_signed_at  DATETIME DEFAULT NULL,
  nca_vendor_signed_at  DATETIME DEFAULT NULL,
  nca_client_signed_at  DATETIME DEFAULT NULL,
  sow_vendor_signed_at  DATETIME DEFAULT NULL,
  sow_client_signed_at  DATETIME DEFAULT NULL,
  nda_text              TEXT DEFAULT NULL,
  tnc_text              TEXT DEFAULT NULL,
  sow_text              TEXT DEFAULT NULL;
-- NCA text fixed/global — admin options-এ একটাই রাখবো, per-contract দরকার নেই
```

**Note:** spa.php ACF (post meta) ব্যবহার করেছিল কারণ সেটা single-order context-এ ছিল। আমাদের ক্ষেত্রে contract-level data, তাই custom table column-এ রাখাই সঠিক — performance এবং consistency দুটোর জন্যই ভালো, কারণ আমরা already custom table architecture বেছে নিয়েছি।

---

## Status Map আপডেট (Final)

| Status Key | UI Label | কখন হয় |
|---|---|---|
| `consulting-pending-confirmation` | 🔒 Pending Signatures | Payment হয়েছে, digital contract sign বাকি |
| `consulting-active` | 🟢 Active | সব sign সম্পূর্ণ, cycle চলছে |
| `consulting-waiting-payment` | 💳 Waiting Payment | Client next cycle pay করেনি |
| `consulting-waiting-vendor` | ⏳ Waiting Vendor | Payment হয়েছে, vendor start করেনি |
| `consulting-completed` | ✅ Completed | সব cycle শেষ, সব accepted |
| `consulting-cancelled` | ❌ Cancelled | যেকোনো সময় cancel |

---

## Updated Task List — নতুন Tasks যুক্ত

### TASK-007.5: Digital Contract Pre-Confirmation (নতুন — TASK-007 এর পরে, TASK-009 এর আগে)

**সাব-টাস্ক:**
- `class-consulting-contract.php`-এ ৮টা sign timestamp + ৩টা text field handle করার method
- `views/digital-contract.php` — accordion UI (NDA, TNC, NCA, SOW)
- AJAX: `consulting_save_document_text` (NDA/TNC/SOW draft save, sign না হওয়া পর্যন্ত)
- AJAX: `consulting_sign_document` (sign timestamp set, role validation: vendor/client)
- Waterfall lock check function: `consulting_is_legal_signed($contract_id)`, `consulting_is_fully_signed($contract_id)`
- NCA fixed text — Admin Settings page-এ global option (`consulting_nca_text`)
- SOW auto-prefill — contract table থেকে units/months/rate pull করে readonly summary বানানো, vendor কে শুধু extra note add করতে দেওয়া
- সব sign হলে hook fire: `consulting_contract_fully_signed` action → status আপডেট `consulting-active` + cycle 1 `started_at` set + vendor/client email notification

### TASK-009 Update (Contract Page)
- Contract page-এর top-এ `consulting-pending-confirmation` status থাকলে **Digital Contract card প্রথমে দেখাবে**, Notice Board ও Session Log card **hidden/locked** থাকবে
- `consulting-active` বা পরের status হলে Digital Contract card **collapsed/minimized** (read-only reference হিসেবে) দেখাবে, Notice Board top-এ আসবে

### TASK-023 Update (Emails)
- E-000: Digital Contract Ready for Signature (client + vendor, payment-এর পরপরই)
- E-000.5: Document Signed by Other Party (যখন একজন sign করে, অন্যজনকে notify)
- E-000.9: Contract Fully Signed — Service Starting (দুজনকেই, cycle 1 শুরুর confirmation)

---

## Coding Order Update

```
TASK-001 → TASK-002 → TASK-003 → TASK-004 → TASK-005 →
TASK-006 → TASK-007 → TASK-007.5 (🆕 Digital Contract) →
TASK-009 → TASK-010 → TASK-011 → TASK-012 → ... (বাকি অপরিবর্তিত)
```

---

# 🆕 CLARIFICATION — Single-Month vs Multi-Month Routing

## সিদ্ধান্ত: সবসময় Contract CPT Page (month সংখ্যা যা-ই হোক)

Client consulting product 1 মাসের জন্য কিনলে বা 12 মাসের জন্য কিনলে — **routing logic identical থাকবে**। কোনো branching বা if/else দিয়ে আলাদা path তৈরি করা হবে না।

```php
// TASK-007 এর redirect logic — month সংখ্যা চেক করার দরকার নেই
if ( is_consulting_product( $product_id ) ) {
    redirect_to( "/consulting-contract/{$contract_number}" );
    // total_cycles = 1 হোক বা 12 হোক — same redirect, same UI
}
```

## কেন এই Decision

| বিষয় | যদি 1-month আলাদা WSS default page দেখাতাম | এখন (সবসময় Contract page) |
|---|---|---|
| Digital Contract (NDA/TNC/NCA/SOW) | দুইবার বানাতে হতো | একবারই বানানো |
| WSS Core Plugin পরিবর্তন | লাগতো (নতুন status hack) | লাগবে না |
| Client experience | Inconsistent | Consistent |
| 1-month → multi-month future extend | জটিল migration | সহজ (already same architecture) |
| Code maintenance | দ্বিগুণ | একক |

## 1-Month Contract-এ Cycle Logic (কোনো Special Case লাগবে না)

`total_cycles = 1` শুধু একটা সংখ্যা — TASK-016 (Accept Delivery Hook)-এর existing logic এটা নিজেই handle করে:

```
Cycle 1 Accept হলে
        ↓
current_cycle (1) === total_cycles (1) ?
        ↓ YES
consulting_finish_contract() চলবে সরাসরি
(next cycle তৈরি হওয়ার কোনো logic ট্রিগার হবে না)
```

## WSS Default Flow কখন ব্যবহার হবে

WSS-এর original `single-order-service.php` page **শুধুমাত্র non-consulting product**-এর জন্য থাকবে — যেমন normal one-time service, বা আগের downloadable-service feature। Consulting product সবসময় `is_consulting_product()` check দিয়ে আলাদা route-এ চলে যাবে checkout-এর পরপরই। দুটো system সম্পূর্ণ আলাদা layer-এ থাকবে, কোনো conflict বা override দরকার নেই।

---

# 🆕 UPDATE — Mid/End-of-Contract Extension Feature

## কী এই Feature

Contract-এর **শেষ cycle চলাকালীন**, client বা vendor কেউ একজন আরও মাস/দিন/ঘণ্টা যুক্ত করার প্রস্তাব দিতে পারবে। অপর পক্ষ Accept করলে এটা **same contract-এই** নতুন cycle হিসেবে যুক্ত হয়ে যাবে — নতুন কোনো contract তৈরি হবে না।

## Final Decisions (আলোচনার পর Confirmed)

| প্রশ্ন | সিদ্ধান্ত |
|---|---|
| Extension prompt কখন দেখাবে | শুধু **শেষ cycle** চলাকালীন (`current_cycle === total_cycles`) |
| Negotiation কীভাবে হবে | WSS chat-এ আলোচনা, formal request শুধু Accept/Reject বাটন |
| Note/reason field | বাদ — extra field দরকার নেই, chat-ই যথেষ্ট |
| Initiator | Vendor বা Client — দুজনেই propose করতে পারবে |
| Approval | অপর পক্ষ শুধু Accept/Reject করবে, counter-offer UI নেই |
| SOW re-sign | লাগবে না — original SOW document touch হবে না |
| Legal trace | `wp_consulting_extensions` table-এর row-ই legal record — কোন তারিখে কোন rate/scope প্রস্তাব ও approve হয়েছিল |
| Payment flow | নতুন কিছু লাগবে না — existing `consulting_advance_to_next_cycle()` (TASK-018) automatically পরের cycle তৈরি করবে এবং payment link পাঠাবে |
| Extension সংখ্যা | Unlimited — যতবার দরকার |

## Database — নতুন Table

```sql
CREATE TABLE wp_consulting_extensions (
  id                  BIGINT UNSIGNED AUTO_INCREMENT,
  contract_id         BIGINT NOT NULL,
  requested_by        VARCHAR(10) NOT NULL,
  requested_by_id     BIGINT NOT NULL,
  additional_months   INT NOT NULL,
  new_units_per_cycle INT NOT NULL,
  new_rate_type       VARCHAR(10),
  new_cycle_price     DECIMAL(10,2),
  status              VARCHAR(20) DEFAULT 'pending',
  requested_at        DATETIME,
  responded_at        DATETIME,
  responded_by_id     BIGINT DEFAULT NULL,
  PRIMARY KEY (id),
  KEY contract_id (contract_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Legal trace ব্যাখ্যা:** এই table-এর row নিজেই প্রমাণ রাখে — `requested_at` + `new_cycle_price` + `new_units_per_cycle` দেখায় কখন কী rate-এ extension প্রস্তাব হয়েছিল, `responded_at` + `responded_by_id` দেখায় কে কখন approve করেছে। তারপর প্রতিটা নতুন cycle-এর `wp_consulting_cycles.amount`-এ সেই rate snapshot হয়ে যায় — তাই প্রতিটা cycle নিজের rate ধরে রাখে, কোনো ambiguity বা mismatch তৈরি হয় না। Original SOW document অপরিবর্তিত থাকে, কোনো নতুন sign UI লাগে না।

## UI Flow

```
শেষ Cycle চলছে (current_cycle === total_cycles)
        ↓
Notice Board-এ Extension Prompt:
"এটা আপনার শেষ cycle। আরও সময় যুক্ত করতে চান?"
[Propose Extension]
        ↓
Extension Request Form:
  - Additional Months
  - Units per Month (days/hours)
  - Rate per Unit
        ↓
অপর পক্ষকে Notification → [Accept] [Reject]
        ↓ (Accept)
total_cycles += additional_months
        ↓
Existing TASK-018 flow পরের cycle তৈরি করে + payment link পাঠায়
```

## Task List Addition

### TASK-032: Extension Request System
- `wp_consulting_extensions` table তৈরি (TASK-001-এর সাথে)
- Notice board-এ extension prompt — শুধু শেষ cycle হলে দেখাবে
- AJAX: propose extension, respond extension (accept/reject)
- Email notifications দুই দিকেই
- একটা সময়ে একটাই pending extension থাকতে পারবে

## Coding Order Update (Final)

TASK-001 (extensions table সহ) → ... → TASK-018 (Advance Cycle) → ... → TASK-032 (Extension)
