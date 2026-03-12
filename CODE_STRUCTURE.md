# Apollo Website - Code Structure & Architecture

## 📋 Overview

This is a **static PHP website** for Apollo Post Production company. The code is well-organized and follows a clear structure, though it's primarily HTML/CSS/JavaScript with minimal PHP logic.

## 🏗️ Architecture

### Type: **Static PHP Site**
- **No database** - All content is hardcoded in HTML/PHP files
- **No backend logic** - PHP is used mainly for file organization
- **Client-side heavy** - Most interactivity handled by JavaScript/jQuery

### Technology Stack:
- **Frontend**: HTML5, CSS3, JavaScript
- **Libraries**: 
  - jQuery 1.11.3 (older version)
  - Bootstrap 5.3.2
  - Font Awesome 4.7.0
  - BxSlider (for image carousels)
- **Server**: PHP 8.5.1 (built-in development server)
- **Styling**: Custom CSS with custom fonts

---

## 📁 Directory Structure

```
apollo-site-main/
│
├── index.php                 # Main homepage (716 lines)
├── Default.html              # Placeholder/fallback page
│
├── home-new/                 # Homepage assets
│   ├── style-new.css         # Main stylesheet (667+ lines)
│   ├── index.php             # Alternative homepage
│   ├── homepreloadervideo.mp4    # Desktop video loader
│   ├── mobilehomepreloadervideo.mp4 # Mobile video loader
│   └── images/               # Homepage images
│
├── work/                     # Roster/work listing page
│   ├── index.php             # Main roster page
│   ├── style-new.css         # Roster-specific styles
│   └── [other roster pages]
│
├── contact/                  # Contact page
│   ├── index.php             # Contact information
│   └── style-new.css         # Contact page styles
│
├── roster/                   # Individual artist pages
│   ├── index.php             # Roster index
│   ├── edit.php              # Editor category page
│   ├── color.php             # Colorist category page
│   ├── sound.php             # Sound category page
│   ├── vfx.php               # VFX category page
│   ├── [artist-name].php     # Individual artist pages
│   ├── videos/               # Video assets
│   │   ├── short/            # Short video clips
│   │   └── images/           # Video thumbnails
│   └── images/               # Artist images
│       └── colorist/          # Colorist portfolio images
│
├── roaster/                  # Alternative roster directory (older?)
│   └── [similar structure to roster/]
│
├── about/                    # About section (appears unused)
│   ├── index.php
│   ├── login.php
│   └── pj.php
│
└── fonts/                    # Typography assets
    ├── logo.png              # Apollo logo
    └── [various font files]
```

---

## 🔍 Code Analysis

### **1. Main Homepage (`index.php`)**

**Structure:**
- **Lines 1-78**: HTML head with CSS (inline styles for video loader)
- **Lines 80-146**: Header with logo and navigation
- **Lines 147-265**: Background video/image containers (15 projects)
- **Lines 266-336**: Main content area with category filters and project list
- **Lines 338-370**: Bootstrap modal for video popups
- **Lines 371-714**: JavaScript/jQuery functionality

**Key Features:**
- **Video Preloader**: Full-screen video that plays on page load
- **Background Images**: Multiple layered background divs for project previews
- **Interactive Gallery**: Hover effects that show different project videos
- **Modal Popups**: Bootstrap modals for displaying full videos with credits

**Data Structure:**
Each project is defined with data attributes:
```html
<a class="openModelItem" 
   data-image='bgimage8' 
   data-prev1="" 
   data-prev2="" 
   data-author="EDIT,SOUND,VFX" 
   data-title="Travis Scott x Jumpman" 
   data-subtitle="TREXX" 
   data-credit="yes" 
   data-credits="<h3>Apollo</h3>...">
```

### **2. JavaScript Functionality**

**Main Scripts (jQuery-based):**

1. **Video Modal Handler** (lines 375-423)
   - Opens Bootstrap modal when project is clicked
   - Loads video iframe from external URL (apollo.gosimian.com)
   - Displays preview images and credits

2. **Page Initialization** (lines 429-434)
   - Fades in header, menu, and content on page load

3. **Hover Effects** (lines 435-454)
   - Shows/hides background videos on project hover
   - Highlights active category filters (Edit/Color/Sound/VFX)

4. **Video Loader** (lines 456-694)
   - Complex video preloader system
   - Handles mobile vs desktop video sources
   - Fallback animations if video fails to load
   - Waits for video to finish before showing content

5. **Sticky Navigation** (lines 695-713)
   - Makes category filters stick to top on scroll

### **3. CSS Architecture**

**Custom Fonts:**
- Multiple custom font families loaded via `@font-face`
- BelleStory, Superior family, LT Superior Mono, New York

**Styling Approach:**
- **Bootstrap 5.3.2** for grid system and components
- **Custom CSS** in `home-new/style-new.css` (667+ lines)
- **Inline styles** for critical video loader animations
- **Responsive design** with media queries

### **4. Roster Pages (`work/index.php`)**

**Structure:**
- Simple HTML structure
- Four main categories: Edit, Color, Sound, VFX
- Each category lists individual artists
- Mobile-responsive with accordion functionality

**JavaScript:**
- Accordion behavior on mobile (width <= 800px)
- Click to expand/collapse categories

---

## ✅ Code Quality Assessment

### **Strengths:**

1. **Clear Organization**
   - Logical directory structure
   - Assets separated by type (videos, images, fonts)
   - Each page has its own directory

2. **Modern Technologies**
   - Bootstrap 5.3.2 (latest)
   - HTML5 semantic elements
   - CSS3 animations and transitions

3. **Responsive Design**
   - Mobile-specific video sources
   - Media queries for different screen sizes
   - Mobile accordion navigation

4. **Performance Considerations**
   - Video preloading with fallbacks
   - Lazy loading considerations
   - CDN for libraries (faster loading)

### **Areas for Improvement:**

1. **jQuery Version**
   - Using jQuery 1.11.3 (from 2015)
   - Should upgrade to jQuery 3.x for security/performance

2. **Code Organization**
   - Large inline JavaScript blocks (300+ lines in index.php)
   - Could be moved to separate `.js` files
   - Inline CSS could be externalized

3. **Data Management**
   - All project data hardcoded in HTML
   - Could use JSON/array for easier management
   - No content management system

4. **Repetitive Code**
   - Similar HTML structure repeated for each project
   - Could use PHP loops or templates

5. **No Build Process**
   - No minification/compression
   - No asset bundling
   - Could benefit from modern build tools

---

## 🔧 How It Works

### **Page Load Flow:**

1. **Initial Load**
   - HTML structure loads
   - Video loader div appears (full screen, black background)
   - JavaScript detects device type (mobile/desktop)

2. **Video Preloader**
   - Sets appropriate video source
   - Attempts autoplay
   - Waits for video to finish or timeout

3. **Content Reveal**
   - Video loader fades out
   - Header, menu, and content fade in
   - Background videos start playing (muted, looped)

4. **User Interaction**
   - Hover over project → background video changes
   - Click project → modal opens with full video
   - Scroll → category filters stick to top

### **Data Flow:**

```
User Action → jQuery Event Handler → 
  → Read data attributes → 
  → Update DOM (show/hide elements) → 
  → Load external video (iframe) → 
  → Display in Bootstrap modal
```

---

## 📊 Code Statistics

- **Total PHP Files**: ~46 files
- **Main Pages**: 3 (homepage, roster, contact)
- **Individual Artist Pages**: ~15+ pages
- **CSS Files**: 3 main stylesheets
- **JavaScript**: Primarily inline in PHP files
- **Video Assets**: 200+ video files
- **Image Assets**: 300+ image files

---

## 🎯 Key Design Patterns

1. **Data-Driven UI**: Uses HTML5 data attributes to store project info
2. **Progressive Enhancement**: Works without JavaScript (basic functionality)
3. **Graceful Degradation**: Fallback animations if videos fail
4. **Component-Based**: Each project is a self-contained component
5. **Event-Driven**: jQuery event handlers for all interactions

---

## 💡 Recommendations

### **For Better Structure:**

1. **Separate Concerns**
   - Move JavaScript to `.js` files
   - Externalize inline CSS
   - Create reusable PHP templates

2. **Modernize**
   - Upgrade jQuery to 3.x
   - Consider vanilla JavaScript (reduce dependencies)
   - Use CSS Grid instead of Bootstrap grid where appropriate

3. **Content Management**
   - Create JSON file for project data
   - Use PHP to loop through projects
   - Easier to add/edit projects

4. **Performance**
   - Lazy load videos
   - Optimize images
   - Minify CSS/JS

---

## 📝 Summary

**Overall Assessment: GOOD ✅**

The code is:
- ✅ **Functional** - Everything works as intended
- ✅ **Organized** - Clear file structure
- ✅ **Modern** - Uses current web standards
- ⚠️ **Could be cleaner** - Some repetitive code
- ⚠️ **Could be more maintainable** - Hardcoded content

**Best For:**
- Portfolio showcase websites
- Video-heavy presentations
- Static content sites
- Small to medium projects

**Not Ideal For:**
- Large-scale applications
- Dynamic content management
- User-generated content
- Complex data relationships

---

The code is well-structured for its purpose (a portfolio showcase), but could benefit from some refactoring for better maintainability and modern best practices.
