FlexFit Pro — Gym Management System

FlexFit Pro is an onsite gym management system designed to replace manual logbooks and paper records with a centralized database. It helps gym owners and staff efficiently manage customer visits, payments, memberships, trainers, and revenue analytics from a single dashboard.

This system is built as a final project focusing on ERD design, normalization, SQL joins, indexing, and query optimization.

🎯 Purpose

Small gyms often rely on handwritten logs to record visits and payments. This leads to:

Lost or incorrect records
Difficulty tracking daily and monthly revenue
No clear way to monitor active members
No history of customer visits
No tracking of which staff handled transactions
Difficulty matching customers with available trainers

FlexFit Pro solves these problems with a structured database and an easy-to-use dashboard for staff and the gym owner.

👥 Target Users
Gym Owner — monitors revenue, visits, memberships, trainers, and staff activity
Gym Staff — logs visits, processes payments, registers customers, and assigns trainers

This system is onsite only and designed for front-desk operations.

✨ Key Features
🏠 Dashboard (Owner)
Total revenue (overall)
Daily revenue
Total visits
Monthly revenue chart
Daily visit chart
👥 Customers
Add and search customers (student / regular)
Prevent duplicate records
View customer profile (visits, payments, membership, trainer)
🗓️ Visit Log
Log every gym entry
Automatically determine visit fee:
₱50 — Student
₱70 — Regular
₱0 — Active member
Track which staff logged the visit
💳 Payments
Record visit and membership payments
Track payment history
Used for revenue analytics
🪪 Memberships
Based on membership payment
Plans: 1 month, 3 months, 1 year
Start date = payment date
Expiration date is computed
Active/Expired status is derived from dates
🏋️ Trainers
Store trainer rate and capacity
Monitor current trainees
Identify available trainers
🤝 Coaching (Trainer Assignment)
Assign customers to available trainers
Track trainer–customer relationships
👤 Staff Accounts
Owner and Staff roles
Track which staff processed visits and payments
🔁 System Flow (When Customer Arrives)
Staff searches customer
If not found → add customer
System checks membership status
If not active → process payment (modal)
Log visit
If customer wants a trainer → assign to available trainer

This flow prevents duplicate data and keeps all records linked to one customer_id.

🗂️ Database Design Highlights

The system follows proper normalization:

Customers stored once
Visits, payments, memberships, and coaching stored separately
All transactions linked through foreign keys
Memberships stored as history, not a status flag
Only one active membership at a time (enforced in code)
⚡ Query Optimization & Indexing

The system applies:

Indexes on frequently searched columns (names, foreign keys, dates)
JOIN queries for dashboards and profiles
Pagination for large tables
Efficient filtering for reports and analytics
🛠️ Technologies Used
PHP (MVC structure)
MySQL (with indexes and foreign keys)
Tailwind CSS (UI styling)
✅ What This Project Demonstrates
ERD and relationship modeling
1NF, 2NF, 3NF normalization
Foreign key constraints with cascade rules
SQL JOIN operations
Query optimization and indexing
Practical onsite gym workflow implementation
📌 Note

FlexFit Pro is designed for onsite gym operations and does not include online booking or online payments. It focuses on improving front-desk efficiency and record accuracy.
