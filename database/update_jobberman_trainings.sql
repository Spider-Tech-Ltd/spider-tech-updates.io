-- ========================================
-- JOBBERMAN TRAINING PROGRAMS - UPDATE QUERIES
-- Use this file if you've already inserted the records
-- This will fix the field distribution issue
-- ========================================

-- ========================================
-- STEP 1: Fix Schema (if needed)
-- ========================================
-- Check if training_image field is too short
-- If it's varchar(64), this will extend it to varchar(255)
ALTER TABLE `trainings_tb` 
MODIFY `training_image` varchar(255) NOT NULL;

-- ========================================
-- STEP 2: Update Soft Skills Course
-- ========================================
UPDATE `trainings_tb` 
SET 
  `training_description` = 'Master essential soft skills including communication, teamwork, emotional intelligence, and problem-solving. 17 engaging lessons, self-paced learning, with shareable certificate. Join 41,000+ students. Rating: 4.9/5',
  
  `training_details` = '<h4 style="color: #111111; font-weight: 700; margin-bottom: 15px;">Transform Your Professional Effectiveness</h4>
<p style="color: #555555; line-height: 1.8; margin-bottom: 15px;">Jobberman&apos;s Soft Skills Training is a comprehensive online program designed to empower professionals with the essential non-technical skills crucial for success in today&apos;s competitive job market.</p>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Coverage:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li>Personal Effectiveness & Time Management</li>
  <li>Effective Communication Skills</li>
  <li>Teamwork & Collaboration Dynamics</li>
  <li>Emotional Intelligence Mastery</li>
  <li>Creativity & Innovation Stimulation</li>
  <li>Critical Thinking & Problem Solving</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">What You&apos;ll Get:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li style="margin-bottom: 8px;"><strong>17 Engaging Lessons</strong> - Video lessons, interactive exercises, and thought-provoking quizzes</li>
  <li style="margin-bottom: 8px;"><strong>Self-Paced Learning</strong> - Study at your own pace with flexibility across web and mobile</li>
  <li style="margin-bottom: 8px;"><strong>Baseline & Final Assessments</strong> - Track your progress and measure your development</li>
  <li style="margin-bottom: 8px;"><strong>Shareable Certificate</strong> - Prestigious certificate upon completion to enhance your career prospects</li>
  <li><strong>Practical Relevance</strong> - Curriculum continuously updated to reflect latest industry trends</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Highlights:</h5>
<p style="color: #555555; line-height: 1.8;">Whether you&apos;re a recent graduate, mid-career professional, or career changer, this program equips you with the skills to excel in your chosen field and stand out as a valuable asset to any organization. Our multifaceted approach combines theoretical knowledge with practical application, ensuring you gain real-world, actionable skills.</p>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Stats:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li>Duration: 2 hours 14 minutes</li>
  <li>Students Enrolled: 41,000+</li>
  <li>Rating: 4.9/5 (704+ reviews)</li>
  <li>Format: 100% Online, Self-Paced</li>
  <li>Prerequisite: None - Open to everyone</li>
</ul>',
  
  `training_image` = 'https://i.roamcdn.net/kazi/ng/base/c5b872f2d4093a5d8ac7fa4c63663ac6/-/advertiser-img-ng-jobs-prod/ng/form-builder/course_241/featured_image_0_1720086680.png'
  
WHERE `training_name` = 'Jobberman Soft Skills Course';

-- ========================================
-- STEP 3: Update Entrepreneurship Course
-- ========================================
UPDATE `trainings_tb` 
SET 
  `training_description` = 'Learn to launch and grow your business with 23 interactive lessons covering business planning, customer management, growth hacking, and financial basics. Self-paced, certificate included. Join 13,000+ entrepreneurs. Rating: 4.9/5',
  
  `training_details` = '<h4 style="color: #111111; font-weight: 700; margin-bottom: 15px;">Turn Your Business Ideas Into Reality</h4>
<p style="color: #555555; line-height: 1.8; margin-bottom: 15px;">A comprehensive program designed to empower aspiring entrepreneurs and small business owners with the essential knowledge and skills needed to succeed in the dynamic world of business. Whether launching a new venture or expanding an existing one, gain the insights and strategies to turn your ideas into reality.</p>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Core Modules Covered:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li style="margin-bottom: 8px;"><strong>Business Preparation & Planning</strong> - Learn strategic planning essentials and lay the groundwork for success</li>
  <li style="margin-bottom: 8px;"><strong>The Business Model Canvas (BMC)</strong> - Create a clear and effective blueprint for your business model</li>
  <li style="margin-bottom: 8px;"><strong>Preparing a Simple Business Plan</strong> - Translate your vision into a practical, actionable business plan</li>
  <li style="margin-bottom: 8px;"><strong>Managing Customers</strong> - Discover strategies to build lasting relationships and drive growth</li>
  <li style="margin-bottom: 8px;"><strong>Growth Hacking Strategies</strong> - Unlock innovative and efficient strategies to accelerate business growth</li>
  <li style="margin-bottom: 8px;"><strong>Leveraging Social Media</strong> - Use social platforms to boost business presence and enhance profitability</li>
  <li><strong>Accounts for Non-Accountants</strong> - Demystify financial aspects of entrepreneurship regardless of your background</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Learning Features:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li style="margin-bottom: 8px;"><strong>Expert Instruction</strong> - Guided by experienced instructors with clarity and simplicity</li>
  <li style="margin-bottom: 8px;"><strong>23 Interactive Lessons</strong> - Engaging content that is directly applicable to your entrepreneurial endeavors</li>
  <li style="margin-bottom: 8px;"><strong>Self-Paced Learning</strong> - Access on web and mobile with complete flexibility</li>
  <li style="margin-bottom: 8px;"><strong>Final Assessment</strong> - Comprehensive evaluation of your entrepreneurial knowledge</li>
  <li><strong>Certificate of Achievement</strong> - Proudly showcase your mastery of entrepreneurship and small business principles</li>
</ul>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">What You&apos;ll Master:</h5>
<p style="color: #555555; line-height: 1.8;">Upon completion, you will possess the knowledge and skills needed to navigate entrepreneurial challenges successfully. From market research and customer management to financial planning and growth strategies, this course provides a complete roadmap for building and scaling your business.</p>

<h5 style="color: #f48221; font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Course Stats:</h5>
<ul style="color: #555555; line-height: 1.8; margin-left: 20px;">
  <li>Duration: 2 hours 49 minutes</li>
  <li>Students Enrolled: 13,000+</li>
  <li>Rating: 4.9/5 (395+ reviews)</li>
  <li>Format: 100% Online, Self-Paced</li>
  <li>Prerequisite: None - Open to aspiring and existing entrepreneurs</li>
</ul>',
  
