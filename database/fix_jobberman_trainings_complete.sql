-- ========================================
-- JOBBERMAN TRAINING PROGRAMS - DATABASE FIX & ENHANCEMENT
-- This script fixes the data distribution issue and adds new metadata fields
-- ========================================

-- ========================================
-- STEP 1: Fix Schema - Extend training_image field
-- ========================================
ALTER TABLE `trainings_tb` 
MODIFY `training_image` varchar(255) NOT NULL;

-- ========================================
-- STEP 2: Add new metadata columns for enhanced course information
-- ========================================
ALTER TABLE `trainings_tb` 
ADD COLUMN IF NOT EXISTS `duration_minutes` INT DEFAULT 0 AFTER `training_image`,
ADD COLUMN IF NOT EXISTS `lessons_count` INT DEFAULT 0 AFTER `duration_minutes`,
ADD COLUMN IF NOT EXISTS `students_enrolled` INT DEFAULT 0 AFTER `lessons_count`,
ADD COLUMN IF NOT EXISTS `rating` DECIMAL(2,1) DEFAULT 0.0 AFTER `students_enrolled`,
ADD COLUMN IF NOT EXISTS `reviews_count` INT DEFAULT 0 AFTER `rating`,
ADD COLUMN IF NOT EXISTS `difficulty_level` ENUM('Beginner','Intermediate','Advanced') DEFAULT 'Beginner' AFTER `reviews_count`,
ADD COLUMN IF NOT EXISTS `category` VARCHAR(50) DEFAULT 'General' AFTER `difficulty_level`,
ADD COLUMN IF NOT EXISTS `is_featured` BOOLEAN DEFAULT FALSE AFTER `category`,
ADD COLUMN IF NOT EXISTS `is_new` BOOLEAN DEFAULT FALSE AFTER `is_featured`;

-- ========================================
-- STEP 3: Fix Jobberman Soft Skills Course Data
-- ========================================
UPDATE `trainings_tb` 
SET 
  -- Short description for card (255 chars max, plain text)
  `training_description` = 'Master essential soft skills including communication, teamwork, emotional intelligence, and problem-solving. 17 engaging lessons, self-paced, with certificate.',
  
  -- Full HTML content for detail page
  `training_details` = '<h4 style="color: #111111; font-weight: 700; margin-bottom: 15px;">Transform Your Professional Effectiveness</h4>
<p style="color: #555555; line-height: 1.8; margin-bottom: 15px;">Jobberman's Soft Skills Training is a comprehensive online program designed to empower professionals with the essential non-technical skills crucial for success in today's competitive job market.</p>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Coverage:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li>Personal Effectiveness & Time Management</li>
  <li>Effective Communication Skills</li>
  <li>Teamwork & Collaboration Dynamics</li>
  <li>Emotional Intelligence Mastery</li>
  <li>Creativity & Innovation Stimulation</li>
  <li>Critical Thinking & Problem Solving</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">What You'll Get:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li style="margin-bottom: 8px;"><strong>17 Engaging Lessons</strong> - Video lessons, interactive exercises, and thought-provoking quizzes</li>
  <li style="margin-bottom: 8px;"><strong>Self-Paced Learning</strong> - Study at your own pace with flexibility across web and mobile</li>
  <li style="margin-bottom: 8px;"><strong>Baseline & Final Assessments</strong> - Track your progress and measure your development</li>
  <li style="margin-bottom: 8px;"><strong>Shareable Certificate</strong> - Prestigious certificate upon completion to enhance your career prospects</li>
  <li><strong>Practical Relevance</strong> - Curriculum continuously updated to reflect latest industry trends</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Highlights:</h5>
<p style="color: #555555; line-height: 1.8;">Whether you're a recent graduate, mid-career professional, or career changer, this program equips you with the skills to excel in your chosen field.</p>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Stats:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li>Duration: 2 hours 14 minutes</li>
  <li>Students Enrolled: 41,000+</li>
  <li>Rating: 4.9/5 (704+ reviews)</li>
  <li>Format: 100% Online, Self-Paced</li>
  <li>Prerequisite: None - Open to everyone</li>
</ul>',
  
  -- Complete image URL (not truncated)
  `training_image` = 'https://i.roamcdn.net/kazi/ng/base/c5b872f2d4093a5d8ac7fa4c63663ac6/-/advertiser-img-ng-jobs-prod/ng/form-builder/course_241/featured_image_0_1720086680.png',
  
  -- Metadata
  `duration_minutes` = 134,
  `lessons_count` = 17,
  `students_enrolled` = 41000,
  `rating` = 4.9,
  `reviews_count` = 704,
  `difficulty_level` = 'Beginner',
  `category` = 'Soft Skills',
  `is_featured` = TRUE,
  `is_new` = FALSE
  
WHERE `training_name` = 'Jobberman Soft Skills Course';

-- ========================================
-- STEP 4: Fix Jobberman Entrepreneurship Course Data
-- ========================================
UPDATE `trainings_tb` 
SET 
  -- Short description for card (255 chars max, plain text)
  `training_description` = 'Learn to launch and grow your business with 23 interactive lessons covering business planning, customer management, growth hacking, and financial basics.',
  
  -- Full HTML content for detail page
  `training_details` = '<h4 style="color: #111111; font-weight: 700; margin-bottom: 15px;">Turn Your Business Ideas Into Reality</h4>
<p style="color: #555555; line-height: 1.8; margin-bottom: 15px;">A comprehensive program designed to empower aspiring entrepreneurs and small business owners with the essential knowledge and skills needed to succeed in the dynamic world of business.</p>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Core Modules Covered:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li style="margin-bottom: 8px;"><strong>Business Preparation & Planning</strong> - Learn strategic planning essentials</li>
  <li style="margin-bottom: 8px;"><strong>The Business Model Canvas (BMC)</strong> - Create an effective business blueprint</li>
  <li style="margin-bottom: 8px;"><strong>Preparing a Simple Business Plan</strong> - Translate vision into action</li>
  <li style="margin-bottom: 8px;"><strong>Managing Customers</strong> - Build lasting relationships</li>
  <li style="margin-bottom: 8px;"><strong>Growth Hacking Strategies</strong> - Accelerate business growth</li>
  <li style="margin-bottom: 8px;"><strong>Leveraging Social Media</strong> - Boost business presence</li>
  <li><strong>Accounts for Non-Accountants</strong> - Demystify financial aspects</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Learning Features:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li style="margin-bottom: 8px;"><strong>Expert Instruction</strong> - Guided by experienced instructors</li>
  <li style="margin-bottom: 8px;"><strong>23 Interactive Lessons</strong> - Engaging, applicable content</li>
  <li style="margin-bottom: 8px;"><strong>Self-Paced Learning</strong> - Access on web and mobile</li>
  <li style="margin-bottom: 8px;"><strong>Final Assessment</strong> - Comprehensive evaluation</li>
  <li><strong>Certificate of Achievement</strong> - Showcase your mastery</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Stats:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li>Duration: 2 hours 49 minutes</li>
  <li>Students Enrolled: 13,000+</li>
  <li>Rating: 4.9/5 (395+ reviews)</li>
  <li>Format: 100% Online, Self-Paced</li>
  <li>Prerequisite: None - Open to entrepreneurs</li>
</ul>',
  
  -- Complete image URL (not truncated)
  `training_image` = 'https://i.roamcdn.net/kazi/ng/base/b2a9be9b837bcd4a91ed30a95fb79bd5/-/advertiser-img-ng-jobs-prod/ng/form-builder/course_243/featured_image_0_1716468734.png',
  
  -- Metadata
  `duration_minutes` = 169,
  `lessons_count` = 23,
  `students_enrolled` = 13000,
  `rating` = 4.9,
  `reviews_count` = 395,
  `difficulty_level` = 'Beginner',
  `category` = 'Entrepreneurship',
  `is_featured` = FALSE,
  `is_new` = FALSE
  
WHERE `training_name` = 'Jobberman Entrepreneurship and Small Business';

-- ========================================
-- STEP 5: Verify the updates
-- ========================================
SELECT 
  id,
  training_name,
  LENGTH(training_description) as desc_length,
  LENGTH(training_details) as details_length,
  LENGTH(training_image) as image_length,
  duration_minutes,
  lessons_count,
  students_enrolled,
  rating,
  category,
  difficulty_level
FROM trainings_tb 
WHERE training_name LIKE 'Jobberman%';

-- Expected Results:
-- desc_length: ~240 characters (plain text)
-- details_length: 2000+ characters (HTML content)
-- image_length: 150+ characters (full URL)
-- All metadata fields populated

-- ========================================
-- NOTES:
-- ========================================
-- 1. training_description now contains SHORT plain text for card previews
-- 2. training_details now contains FULL HTML content for program detail page
-- 3. training_image now contains complete CDN URLs (not truncated)
-- 4. All new metadata fields are populated for enhanced UI display
-- 5. After running this, test trainings.php and program-detail.php
-- ========================================