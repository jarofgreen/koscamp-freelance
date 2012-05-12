INSERT INTO `jobberland_admin` (`id`, `username`, `passwd`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

INSERT INTO jobberland_payment_modules (id, name, module_key, class_file, formfile, enabled) VALUES 
(1, 'PayPal', 'paypal', 'paypal.php', 'frmpaypal.tpl', 'N');

REPLACE INTO jobberland_setting_category (id, category_name, var_name, category_desc ) VALUES 
(1, 'Main Settings',  'main_setting', 'The main settings. This includes settings such as site name, meta-tags etc.'),
(2, 'SEO Setting', 'seo_setting', 'Search Engine Optimization '),
(3, 'Mailer Settings ', 'mail_setting', 'Setting for PHP Mailler. Server name ect...'),
(4, 'Spam Settings', 'spam_setting', 'Set your spam setting. Built-in support for ReCaptcha. Before you can enable this, you''ll need to register a free key at recaptcha.net.'),
(5, 'Search / Pagination Settings ', 'search', 'Settings that change the amount of jobs to display per page. Spotlight Jobs, Latest Jobs, Search Job per page, ect...'),
(7, 'User/Employee ', 'user_setting', 'Setting for User/Employee, number cv upload/letters ect..'),
(8, 'Employer', 'employer_setting', 'Setting for Employer/Clint'),
(9, 'Currency', 'currency_setting', 'Setting your currency');

REPLACE INTO jobberland_setting (id, fk_category_id, setting_name, title, description, data_type, input_type, input_options, validation, value) VALUES
(NULL, 1, 'SITE_IN_DEVELOPER_MODE', 'Site developer mode', 'If you working on this site and would like to see all the errors message with sql code', NULL, 'select', 'Y|N', 'not_empty', 'N'),
(NULL, 1, 'SITE_NAME', 'Site name', 'The name of your website.', NULL, 'text', NULL, 'not_empty', 'Jobberland'),
(NULL, 1, 'SITE_LOGO', 'Site logo', 'Site Banner including logo to be displayed in the TOP. (e.g. /images/logo.gif).', NULL, 'text', NULL, 'not_empty', 'images/logo.gif'),
(NULL, 1, 'SITE_SLOGAN', 'Site Slogan ', 'Site Slogan which is show under logo', NULL, 'text', NULL, 'not_empty', 'Find your proper job at Jobberland!'),
(NULL, 1, 'APPLY_WITHOUT_LOGIN', 'Apply with out loggin in', 'Can Employee apply for job(s) without logging into account', 'integer', 'select', "N|Y", 'not_empty', 'Y'),
(NULL, 1, 'HOME_DISPLAY', 'Display Top Ten', 'Display Top Ten days job / categories / cities on home page', NULL, 'select', 'no|topten|categories|cities', NULL, 'no'),
(NULL, 1, 'ADMIN_EMAIL', 'Admin Email', 'This is the admin email. The email companies will receive mail from.', NULL, 'text', NULL, 'not_empty|is_email', 'info@jobberland.com'),
(NULL, 1, 'NO_REPLY_EMAIL', 'Do not reply back to this email', 'This email is only use to send email, Not beening monitored by admin.', NULL, 'text', NULL, NULL, 'info@jobberland.com'),
(NULL, 1, 'NOTIFY_EMAIL', 'Notify Email', 'The email for receiving new job postings.', NULL, 'text', NULL, 'not_empty|is_email', 'info@jobberland.com'),

(NULL, 1, 'DATE_TIME_FORMAT', 'Date / Time format', 'The format in which times are displayed. %d = day, %m = month, %Y = 4 digit year, %H = 24-hour and %i = minute. Follow <a href="http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_date-format" target="_blank">this link</a> for more formatting options.', NULL, 'text', NULL, 'not_empty', '%d-%b-%Y %H:%i'),
(NULL, 1, 'DATE_FORMAT', 'Date format', 'The format in which dates are displayed. %d = day, %m = month, %Y = 4 digit year. Follow <a href="http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_date-format" target="_blank">this link</a> for more formatting options.', NULL, 'text', NULL, 'not_empty', '%d-%b-%Y'),
(NULL, 1, 'MINUTES_BETWEEN_APPLY_TO_JOBS_FROM_SAME_IP', 'Apply delay', 'The number of minutes that must pass between applications from the same IP address', NULL, 'text', NULL, 'not_empty|is_number', '0'), 
(NULL, 1, 'OLD_JOB_NOTIFY', 'Old Job Notify', 'No. of days after which a job should be reported as old. Use 0 to disable this functionality.', 'integer', 'text', NULL, 'not_empty', '40'),

(NULL, 1, 'TEMPLATE', 'Site Template', 'Select template for site from list', 'integer', 'template', NULL, 'not_empty', 'default'),
(NULL, 1, 'DEFAULT_COUNTRY', 'Default country', 'Select Country which this script is running in', 'integer', 'country', NULL, 'not_empty', 'GB'),
(NULL, 1, 'PIC_WIDTH', 'Listing Picture Width', 'Enter Width of the images which can be uploaded. e.g. logo', 'integer', 'text', NULL, 'not_empty', '200'),
(NULL, 1, 'PIC_HEIGHT', 'Listing Picture Height', 'Enter Height of the images which can be uploaded. e.g. logo', 'integer', 'text', NULL, 'not_empty', '200'),

(NULL, 2, 'PAGE_TITLE', 'Title', 'Page Title.<br />Maximum 255 characters', NULL, 'text', NULL, NULL, 'Build a Better Career.  Find Your Calling. Employment and Recruitment - Jobberland.com'),
(NULL, 2, 'META_KEYWORDS', 'Site keywords', 'Meta Keywords. Useful for Search Engine Optimization (separate by comma).<br />Maximum 255 characters', NULL, 'textarea', NULL, NULL, 'job, jobs, job sites, job vacancies, find a job, search jobs, resume tips, monster, job search engines, internet jobs, it jobs, computer jobs, retail jobs, healthcare jobs, sales jobs, finance jobs, engineering jobs, legal jobs, human resources jobs, HR j'),
(NULL, 2, 'META_DESCRIPTION', 'Site description', 'Meta Description Tag. Useful for Search Engine Optimization.<br />Maximum 255 characters', NULL, 'textarea', NULL, NULL, 'Find the job that''s right for you. Use jobberland.com resources to create a killer resume, search for jobs, prepare for interviews, and launch your career.'),

(NULL, 3, 'MAILER_HOST', 'SMTP host name', 'Host name (for example, smtp.example.com)', NULL, 'text', NULL, NULL, ''),
(NULL, 3, 'MAILER_USERNAME', 'SMTP user name', 'User name (for example, user@example.com)', NULL, 'text', NULL, NULL, ''),
(NULL, 3, 'MAILER_PASSWORD', 'SMTP password', 'Password', NULL, 'text', NULL, NULL, ''),
(NULL, 3, 'MAILER_PORT', 'SMTP port', 'Port (default is 25, change only if you know what you are doing)', 'integer', 'text', NULL, 'not_empty', ''),
(NULL, 3, 'MAILER_AUTH', 'SMTP authentication', 'Is authentication required for SMTP? true or false', 'boolean', 'radio', 'true|false', NULL, 'true'),
(NULL, 3, 'MAILER_TEST', 'Mailer is in testing mode', 'true or false', NULL, 'radio', 'true|false', NULL, 'false'),
(NULL, 3, 'mailer_smtp_secure_connection_prefix', 'SMTP secure connection prefix', 'SMTP secure connection prefix. Leave empty if not specified for your host. e.g. ssl or tls', NULL, 'select', ' |ssl|tls', NULL, ''),

(NULL, 4, 'ENABLE_SPAM_REGISTER', 'Enable SPAM Security Code on register page:', 'Enable spam protection on the register page.', 'boolean', 'select', 'N|Y', NULL, 'N'),
(NULL, 4, 'ENABLE_SPAM_LOGIN', 'Enable SPAM Security Code on login page:', 'Enable spam protection on the login page.', 'boolean', 'select', 'N|Y', NULL, 'N'),
(NULL, 4, 'ENABLE_SPAM_APPLY_JOB', 'Enable SPAM Security Code on apply page:', 'Enable spam protection on the apply to a job page. ', 'boolean', 'select', 'N|Y', NULL, 'N'),
(NULL, 4, 'ENABLE_SPAM_CONTACT', 'Enable SPAM Security Code on contact page:', 'Enable spam protection on the contact page.', 'boolean', 'select', 'N|Y', NULL, 'N'),
(NULL, 4, 'ENABLE_SPAM_SHARE', 'Enable SPAM Security Code on Share it with a friend page:', 'Enable spam protection on the Share it with a friend page.', 'boolean', 'select', 'N|Y', NULL, 'N'),
(NULL, 4, 'ENABLE_SPAM_FEEDBACK', 'Enable SPAM Security Code on Feedback page:', 'Enable spam protection on the Feedback page.', 'boolean', 'select', 'N|Y', NULL, 'N'),
(NULL, 4, 'ENABLE_SPAM_FD', 'Enable SPAM Security Code on Forget Details page:', 'Enable spam protection on the Forget Details page.', 'boolean', 'select', 'N|Y', NULL, 'N'),
(NULL, 4, 'ENABLE_SPAM_RSC', 'Enable SPAM Security Code on Re-send the confirmation email page:', 'Enable spam protection on the Re-send the confirmation email page.', 'boolean', 'select', 'N|Y', NULL, 'N'),

(NULL, 5, 'JOBS_PER_SEARCH', 'Jobs per search', 'The amount of jobs per page when searching.Employer / Employee', 'integer', 'text', NULL, 'not_empty', '10'),
(NULL, 5, 'JOBS_PER_PAGE', 'Jobs per page', 'The amount of jobs per page, before pagination is called.', 'integer', 'text', NULL, 'not_empty', '10'),
(NULL, 5, 'MAX_CATEGORY', 'Max # Categories', 'Max # Categories to show on Left side of page', NULL, 'text', NULL, NULL, '5'),
(NULL, 5, 'MAX_RECRUITING', 'Max # Recruiting Now', 'Max # Recruiting Now to show on Left side of page', NULL, 'text', NULL, NULL, '5'),
(NULL, 5, 'LATEST_JOBS', 'Latest Jobs #', 'Amount of latest jobs to show on the front page. This is show at the top user can see latest jobs added to system', 'integer', 'text', NULL, 'not_empty', '4'),
(NULL, 5, 'SPOTLIGHT_JOBS', 'Spotlight Jobs #', 'Amount of Spotlight Jobs to display on the front page.', 'integer', 'text', NULL, 'not_empty', '4'),
(NULL, 5, 'JOB_BY_DATE_MAX', 'Max No of days display', 'Display max number of days on home page only', 'integer', 'select', '5|10|15|20|25|30|40|50|60|80|100', 'not_empty', '5'),
(NULL, 5, 'JOB_BY_DATE_GROUP_MAX', 'Max No of jobs display', 'Display max number of jobs per a days.', 'integer', 'select', '1|3|5|7|9|10|11|13|15|20|25|30|40', 'not_empty', '8'),

(NULL, 7, 'ACTIVE_EMPLOYEE_AUTO', 'By default, Employee to be active or not?', 'Active Employee by defult without admin ', NULL, 'select', 'Y|N', NULL, 'N'),
(NULL, 7, 'REG_CONFIRMATION', 'Bypass registration confirmation by the user?', 'Bypass registration confirmation by the user?', NULL, 'select', 'Y|N', NULL, 'N'),
(NULL, 7, 'MAX_CV', 'No. CV Upload', 'No. of cv can be upload by user', NULL, 'text', NULL, NULL, '5'),
(NULL, 7, 'MAX_COVER_LETTER', 'No. Covering Letter Upload', 'No. of cvering letter can be upload by user', NULL, 'text', NULL, NULL, '5'),
(NULL, 7, 'FILE_UPLOAD_DIR', 'Upload Directory', 'Upload directory to save CV''s. If not existed then it will be created. if Not set it will be upload/ as defult', NULL, 'textarea', NULL, 'not_empty', 'cv/'),
(NULL, 7, 'ALLOWED_FILE_TYPES_IMG', 'Images which can be uploaded', 'These will be the types of images file that will pass the validation\r\npng,gif,jpg,jpeg,jpe\r\n', NULL, 'textarea', NULL, NULL, 'png,gif,jpg,jpeg,jpe'),
(NULL, 7, 'MAX_CV_SIZE', 'Max CV filesize', 'The maximum filesize for uploaded CV''s in bytes (Update accordingly in translations.ini)', NULL, 'text', NULL, 'not_empty|is_number', '262144'),
(NULL, 7, 'ALLOWED_FILETYPES_DOC', 'Documents which can be uploaded', 'These will be the types of Documents that will pass the validation doc,docx,pdf,rtf,txt ', NULL, 'textarea', NULL, NULL, 'doc,docx,pdf,rtf,txt'),

(NULL, 8, 'EMPLOYER_REG', 'Enable Employer/Clint Registration', 'Allow employer/Clint to register on website', 'boolean', 'select', 'N|Y', 'not_empty', 'Y'),
(NULL, 8, 'FREE_SITE', 'Employer/Clint can post or search free', 'Allow employer/Clint to post or search for free. No Cost 100% free', 'boolean', 'select', 'N|Y', 'not_empty', 'Y'),
(NULL, 8, 'ACTIVE_EMPLOYER_AUTO', 'By default, Employer to be active or not?', 'Active Employer by defult without admin ', NULL, 'select', 'Y|N', NULL, 'Y'),
(NULL, 8, 'REG_CONFIRMATION_EMP', 'Bypass registration confirmation by the employer?', 'Bypass registration confirmation by the employer/clint?. User need to comfirm email befre they can use our system', NULL, 'select', 'Y|N', NULL, 'Y'),
(NULL, 8, 'ENABLE_NEW_JOBS', 'Enable Job Posting', 'This option will enable jobs when they added. By turning this off, the only way to enable jobs is by user control panel or through the admin-panel.', 'boolean', 'select', 'N|Y', NULL, 'Y'),
(NULL, 8, 'APPROVE_JOB', 'Approve Jobs', 'Approve Jobs Automatically with out admin approve. By turning this off, the only way to approve jobs is through the admin-panel  ', NULL, 'select', 'N|Y', NULL, 'Y'),
(NULL, 8, 'JOBLASTFOR', 'Number of days to run job', 'Number of days job will be disply on-line', NULL, 'text', NULL, NULL, '30'),
(NULL, 8, 'NO_DELETE_OLD_JOB', 'Delete old job', 'No. of days after which a job should be deleted. Use 0 to disable this functionality.', NULL, 'text', NULL, NULL, '60'),
(NULL, 8, 'START_CREDIT_POST', 'Free Job Post Credits ', '# of free credits on register, standard single posts', NULL, 'text', NULL, NULL, '0'),
(NULL, 8, 'START_CREDIT_SPOTLIGHT', 'Free Spotlight Job Post Credits ', '# of free credits on register, Spltlight  posts', NULL, 'text', NULL, NULL, '0'),
(NULL, 8, 'START_CREDIT_CV_SEARCH', 'Free CV Search Credits ', '# of free credits on register, CV Search credits', NULL, 'text', NULL, NULL, '0'),

(NULL, 9, 'CURRENCY_NAME', 'Billing Currency Sign', 'This currency sign will be used for displaying your site services prices', NULL, 'currency_symbol', NULL, NULL, 'GBP');

INSERT INTO `jobberland_career_degree` (`id`, `var_name`, `career_name`, `is_active`) VALUES
(1, 'none-of-these', 'None of these', 'Y'),
(2, 'student-higher-education-graduate', 'Student (Higher education/Graduate)', 'Y'),
(3, 'entry-level', 'Entry Level', 'Y'),
(4, 'experienced-non-manager', 'Experienced (Non-Manager)', 'Y'),
(5, 'manager-manager-supervisor-of-staff', 'Manager (Manager/Supervisor of Staff)', 'Y'),
(6, 'executive-director-department-head', 'Executive (Director, Department Head)', 'Y'),
(7, 'senior-executive-chairman-md-ceo', 'Senior Executive (Chairman, MD, CEO)', 'Y');

INSERT INTO `jobberland_category` (`id`, `var_name`, `cat_name`) VALUES
(1, 'accounting-and-auditing-services', 'Accounting and Auditing Services'),
(2, 'advertising-and-pr-services', 'Advertising and PR Services'),
(3, 'aerospace-and-defence', 'Aerospace and Defence'),
(4, 'agriculture-forestry-fishing', 'Agriculture/Forestry/Fishing'),
(5, 'architectural-and-design-services', 'Architectural and Design Services'),
(6, 'automotive-and-parts-mfg', 'Automotive and Parts Mfg'),
(7, 'automotive-sales-and-repair-services', 'Automotive Sales and Repair Services'),
(8, 'banking-and-consumer-lending', 'Banking and Consumer Lending'),
(9, 'biotechnology-pharmaceuticals', 'Biotechnology/Pharmaceuticals'),
(10, 'broadcasting-music-and-film', 'Broadcasting, Music, and Film'),
(11, 'business-services-other', 'Business Services - Other'),
(12, 'chemicals-petro-chemicals', 'Chemicals/Petro-Chemicals'),
(13, 'clothing-and-textile-manufacturing', 'Clothing and Textile Manufacturing'),
(14, 'computer-hardware', 'Computer Hardware'),
(15, 'computer-software', 'Computer Software'),
(16, 'computer-it-services', 'Computer/IT Services'),
(17, 'construction-industrial-facilities-and-infrastructure', 'Construction - Industrial Facilities and Infrastructure'),
(18, 'construction-residential-commercial-office', 'Construction - Residential & Commercial/Office'),
(19, 'education', 'Education'),
(20, 'electronics-components-and-semiconductor-mfg', 'Electronics, Components, and Semiconductor Mfg'),
(21, 'energy-and-utilities', 'Energy and Utilities'),
(22, 'engineering-services', 'Engineering Services'),
(23, 'entertainment-venues-and-theatres', 'Entertainment Venues and Theatres'),
(24, 'financial-services', 'Financial Services'),
(25, 'food-and-beverage-production', 'Food and Beverage Production'),
(26, 'government-and-public-sector', 'Government and Public Sector'),
(27, 'healthcare-services', 'Healthcare Services'),
(28, 'hotels-and-lodging', 'Hotels and Lodging'),
(29, 'insurance', 'Insurance '),
(30, 'internet-services', 'Internet Services'),
(31, 'legal-services', 'Legal Services'),
(32, 'management-consulting-services', 'Management Consulting Services'),
(33, 'manufacturing-other', 'Manufacturing - Other'),
(34, 'marine-mfg-services', 'Marine Mfg & Services'),
(35, 'medical-devices-and-supplies', 'Medical Devices and Supplies'),
(36, 'metals-and-minerals', 'Metals and Minerals'),
(37, 'non-profit-charitable-organisations', 'Non profit Charitable Organisations'),
(38, 'other-not-classified', 'Other/Not Classified'),
(39, 'performing-and-fine-arts', 'Performing and Fine Arts'),
(40, 'personal-and-household-services', 'Personal and Household Services'),
(41, 'personal-care-products-and-cosmetics', 'Personal Care Products and Cosmetics'),
(42, 'printing-and-publishing', 'Printing and Publishing '),
(43, 'real-estate-and-property-management', 'Real Estate and Property Management'),
(44, 'rental-services', 'Rental Services'),
(45, 'restaurant-food-services', 'Restaurant/Food Services'),
(46, 'retail', 'Retail'),
(47, 'security-and-surveillance', 'Security and Surveillance'),
(48, 'sports-and-physical-recreation', 'Sports and Physical Recreation'),
(49, 'staffing-employment-agencies', 'Staffing/Employment Agencies'),
(50, 'telecommunications-services', 'Telecommunications Services'),
(51, 'transport-and-storage-materials', 'Transport and Storage - Materials '),
(52, 'travel-transportation-and-tourism', 'Travel, Transportation and Tourism '),
(53, 'waste-management', 'Waste Management'),
(54, 'wholesale-trade-import-export', 'Wholesale Trade/Import-Export');

INSERT INTO `jobberland_education` (`id`, `var_name`, `education_name`, `is_active`) VALUES
(1, 'some-secondary-school-coursework', 'Some Secondary School Coursework', 'Y'),
(2, 'secondary-school-or-equivalent', 'Secondary School or equivalent', 'Y'),
(3, 'a-level-higher-or-equivalent', 'A Level/Higher or Equivalent', 'Y'),
(4, 'vocational', 'Vocational', 'Y'),
(5, 'some-college-coursework-completed', 'Some College Coursework Completed', 'Y'),
(6, 'hnd-hnc-or-equivalent', 'HND/HNC or equivalent', 'Y'),
(7, 'doctorate', 'Doctorate', 'Y'),
(8, 'professional', 'Professional', 'Y');

INSERT INTO `jobberland_experience` (`id`, `var_name`, `experience_name`, `is_active`) VALUES
(1, 'less-than-1-year', 'Less than 1 Year', 'Y'),
(2, '1-to-2-years', '1+ to 2 Years', 'Y'),
(3, '2-to-5-years', '2+ to 5 Years', 'Y'),
(4, '5-to-7-years', '5+ to 7 Years', 'Y'),
(5, '7-to-10-years', '7+ to 10 Years', 'Y'),
(6, '10-to-15-years', '10 to 15 Years', 'Y'),
(7, 'more-than-15-years', 'More than 15 Years', 'Y');


INSERT INTO `jobberland_job_status` (`id`, `var_name`, `status_name`, `is_active`) VALUES
(1, 'permanent', 'Permanent', 'Y'),
(2, 'part-time', 'Part-Time', 'Y'),
(3, 'contract', 'Contract', 'Y'),
(4, 'temporary-contract-project', 'Temporary/Contract/Project', 'Y'),
(5, 'placement-student', 'Placement Student', 'Y'),
(6, 'seasonal', 'Seasonal', 'Y');

INSERT INTO `jobberland_job_type` (`id`, `var_name`, `type_name`, `is_active`) VALUES
(1, 'full-time', 'Full-time', 'Y'),
(2, 'part-time', 'Part-time', 'Y'),
(3, 'per-day', 'Per Day', 'Y');

