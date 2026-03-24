# JOBBERMAN TRAINING PROGRAMS - DATABASE INSERTION GUIDE

## ⚠️ IMPORTANT UPDATE - March 23, 2026

**This guide has been updated to fix the database field distribution issue.**

The original SQL queries had a critical flaw: they put all HTML content into `training_description` (varchar 255) instead of properly splitting data between `training_description` (short summary) and `training_details` (full content).

**For the corrected SQL queries, see:**
- [`plans/sql_queries_for_jobberman_fix.md`](../plans/sql_queries_for_jobberman_fix.md) - Complete SQL queries
- [`plans/jobberman_trainings_fix_plan.md`](../plans/jobberman_trainings_fix_plan.md) - Detailed implementation plan

---

## Overview
This document contains professional, ready-to-insert database records for two Jobberman training programs:
1. **Jobberman Soft Skills Course** (Self-Paced)
2. **Jobberman Entrepreneurship and Small Business Course**

---

## PROGRAM 1: JOBBERMAN SOFT SKILLS COURSE

### Basic Information
- **Program Name:** Jobberman Soft Skills Course
- **Provider:** Jobberman
- **Duration:** 2 hours 14 minutes
- **Format:** Self-Paced, 100% Online
- **Course Rating:** 4.9/5 stars (704+ reviews)
- **Total Students:** 41,000+
- **Lessons:** 17
- **Prerequisites:** None

### Program Image URL
```
https://i.roamcdn.net/kazi/ng/base/c5b872f2d4093a5d8ac7fa4c63663ac6/-/advertiser-img-ng-jobs-prod/ng/form-builder/course_241/featured_image_0_1720086680.png
```

### Program Description Summary
Jobberman's Soft Skills Training is a transformative online program designed to empower individuals with comprehensive non-technical skills crucial for success in today's competitive job market.

### Key Topics Covered
- Personal Effectiveness & Time Management
- Effective Communication Skills
- Teamwork & Collaboration Dynamics
- Emotional Intelligence Mastery
- Creativity & Innovation Stimulation
- Critical Thinking & Problem Solving

### Learning Methodology
- Interactive video lessons
- Practical exercises
- Thought-provoking quizzes
- Baseline and final assessments to track progress
- Self-paced, flexible learning
- Accessible on web and mobile platforms

### Certificate & Credential
- Shareable certificate of completion
- Enhances employability and career prospects
- Recognized by employers

### Ideal For
- Recent graduates
- Mid-career professionals
- Career changers
- Anyone looking to improve workplace skills
- Professionals seeking to enhance communication, leadership, and teamwork abilities

### Course Highlights
- Continuously updated curriculum reflecting latest industry trends
- Practical, relevant content directly applicable to the modern workplace
- Expert-designed content focused on employability
- Flexible learning suited for working professionals
- High student satisfaction (4.9/5 rating)

---

## PROGRAM 2: JOBBERMAN ENTREPRENEURSHIP AND SMALL BUSINESS COURSE

### Basic Information
- **Program Name:** Jobberman Entrepreneurship and Small Business
- **Provider:** Jobberman
- **Duration:** 2 hours 49 minutes
- **Format:** Self-Paced, 100% Online
- **Course Rating:** 4.9/5 stars (395+ reviews)
- **Total Students:** 13,000+
- **Lessons:** 23
- **Prerequisites:** None

### Program Image URL
```
https://i.roamcdn.net/kazi/ng/base/b2a9be9b837bcd4a91ed30a95fb79bd5/-/advertiser-img-ng-jobs-prod/ng/form-builder/course_243/featured_image_0_1716468734.png
```

### Program Description Summary
A comprehensive program designed to empower aspiring entrepreneurs and small business owners with essential knowledge and skills needed to succeed in the dynamic world of business. Perfect for those launching new ventures or expanding existing ones.

### Core Modules (7 Major Sections)

1. **Business Preparation & Planning**
   - Strategic planning essentials
   - Laying groundwork for business success
   - Market research fundamentals

2. **The Business Model Canvas (BMC)**
   - Creating effective business blueprints
   - Visual planning methodology
   - Key value propositions

3. **Preparing a Simple Business Plan**
   - Translating vision into action
   - Practical business planning
   - Roadmap creation

4. **Managing Customers**
   - Customer relationship strategies
   - Building lasting connections
   - Growth through customer focus

5. **Growth Hacking Strategies**
   - Innovative growth techniques
   - Efficient scaling methodologies
   - Data-driven growth approaches

6. **Leveraging Social Media**
   - Business presence on social platforms
   - Digital marketing strategies
   - Profitability enhancement through social media

7. **Accounts for Non-Accountants**
   - Demystifying business finance
   - Financial management basics
   - Budgeting and cash flow

### Learning Features
- Expert instruction with clarity and simplicity
- 23 interactive lessons covering all essential topics
- Self-paced learning with mobile accessibility
- Real-world, actionable strategies
- Comprehensive final assessment
- Certificate of achievement upon completion

### Ideal For
- Aspiring entrepreneurs
- First-time business owners
- Small business operators
- Business expansion seekers
- Professionals transitioning to entrepreneurship
- Anyone with a business idea wanting to turn it into reality

### Course Highlights
- Industrial-grade methodology
- Practical, directly applicable content
- Expert-designed curriculum
- High success rate (4.9/5 rating)
- Flexible, time-efficient learning
- Access to proven business frameworks

---

## IMPLEMENTATION INSTRUCTIONS

### Step 1: Verify Database Connection
Ensure you have access to your MySQL database (spider_tech_updated_db) through phpMyAdmin or MySQL CLI.

### Step 2: Copy INSERT Statements
Use the SQL file `/database/insert_jobberman_trainings.sql` which contains optimized INSERT queries for both courses.

### Step 3: Execute in Database
Run the queries in your database management tool:
- Option A: Via phpMyAdmin - Navigate to SQL tab and paste the entire query
- Option B: Via MySQL CLI - Use: `mysql -u username -p database_name < insert_jobberman_trainings.sql`

### Step 4: Verify Insertion
Check that records were successfully inserted:
```sql
SELECT * FROM trainings_tb WHERE training_name LIKE 'Jobberman%';
```

### Step 5: Visit Trainings Page
Navigate to `/trainings.php` in your Spider Tech application to verify:
- Courses appear in the programs listing
- Images load correctly
- Descriptions display properly
- "View Details" links work

### Step 6: Test Registration Flow
- Click on a course card
- Verify program-detail.php loads with course information
- Test the registration form
- Confirm data saves to database

---

## TECHNICAL DETAILS

### Table Structure (trainings_tb)
- **id**: Auto-increment primary key
- **training_name**: Course title (VARCHAR 100)
- **training_description**: **SHORT plain-text summary** (VARCHAR 255) - Used for card previews
- **training_details**: **FULL HTML content** (TEXT) - Used for program detail page
- **training_icon**: Icon class name (VARCHAR 64)
- **training_image**: External image URL (VARCHAR 255) - **Must be extended from 64 to 255**

### ⚠️ Critical Database Field Usage

**IMPORTANT**: The database has TWO separate fields for content:

1. **`training_description` (varchar 255)**
   - **Purpose**: Short summary for training cards
   - **Max Length**: 255 characters
   - **Format**: Plain text, NO HTML
   - **Example**: "Master essential soft skills including communication, teamwork, emotional intelligence..."

2. **`training_details` (text)**
   - **Purpose**: Full course information for detail page
   - **Max Length**: Unlimited
   - **Format**: Rich HTML with styling
   - **Example**: `<h4>Transform Your Professional Effectiveness</h4><p>Comprehensive description...</p>`

### Database Considerations
- Images are hosted on Jobberman's CDN (roamcdn.net) ensuring professional quality
- **Schema Fix Required**: `training_image` field must be extended from varchar(64) to varchar(255)
- HTML formatting in `training_details` maintains professional styling
- All text is properly escaped for security
- Inserting these courses won't affect existing data

### SEO & Profile Metrics
- **Soft Skills Course**: 4.9★ rating, 41,000+ students, industry leader
- **Entrepreneurship Course**: 4.9★ rating, 13,000+ students, comprehensive curriculum
- Both courses are highly rated and trusted by thousands of learners

---

## COURSE CONTENT PREVIEW

### How Courses Appear on Trainings Page

**Featured Card (First Course)**
- Large hero display
- Course title prominently displayed
- Brief description visible
- "View Program" button
- Visual prominence with gradient background

**Regular Cards (Subsequent Courses)**
- High-quality thumbnail images
- Course category badge
- Course title with truncation for long names
- 3-line description preview
- "View Details" link
- Provider attribution

### Program Detail Page Display
When users click on a course:
- Full course information displayed
- Complete curriculum breakdown
- Enrollment form with validation
- Email confirmation upon registration
- Database storage of registrations

---

## RECOMMENDED NEXT STEPS

1. **Insert Both Courses** into the database using the provided SQL file
2. **Verify Display** on trainings.php page
3. **Test Registration Flow** to ensure all forms work
4. **Monitor Enrollments** via the program_registrations table
5. **Consider Adding More Jobberman Courses** for expanded offerings
6. **Update Course Materials** periodically based on learner feedback

---

## ADDITIONAL JOBBERMAN COURSES AVAILABLE

For future expansion, consider these additional Jobberman courses:
- Jobberman Financial Literacy Course (4.6★, 5,000+ students)
- Digital Skills: Become a Successful Global Gig Worker (4.9★, 6,000+ students)
- Soft Skills Training - WhatsApp Format (Interactive format)

---

## SUPPORT & QUESTIONS

- **Course Platform**: Jobberman (https://www.jobberman.com/learning/courses)
- **Database File**: `/database/insert_jobberman_trainings.sql`
- **Trainings Page**: `/trainings.php`
- **Program Detail Page**: `/program-detail.php`
- **Registration Handler**: `/includes/submit_program_registration.php`

---

**Document Version**: 1.0  
**Date Created**: March 23, 2026  
**Status**: Ready for Database Insertion
