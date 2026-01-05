# PRD.md

# Product Requirements Document: Flat Survey System

## 1. Overview

### 1.1 Product Vision
A lightweight, file-based survey system that allows non-technical editors to create and deploy surveys without databases, complex configurations, or hosting requirements beyond basic PHP support.

### 1.2 Target Users
- **Survey Editors**: Graphic designers, researchers, educators who need simple surveys
- **Survey Respondents**: Anyone with a web browser
- **Results Viewers**: Project owners, researchers analyzing collected data

### 1.3 Core Value Proposition
- Zero-configuration deployment
- No database management required
- Simple CSV-based survey creation
- Mobile-responsive design
- Real-time results visualization

## 2. Functional Requirements

### 2.1 Survey Creation (Editor Experience)
**FR-001**: Editors can define surveys via CSV files
- Supports multiple question types (text, scales, options)
- Configurable required/optional questions
- Custom labels and scale ranges

**FR-002**: CSV Structure Support
- Minimum 8-column CSV format
- Variable column usage based on question type
- Support for all survey elements (title, description, questions, answers, separators, submit button)

**FR-003**: Question Types
- Text input (single line)
- Rating scales (3-option, 4-option, 5-option, 7-option)
- Binary options (Yes/No, True/False)
- Checkbox acceptance
- Custom scale ranges (e.g., -2 to +2)

### 2.2 Survey Display (Respondent Experience)
**FR-004**: Responsive Design
- Mobile-first approach
- Single breakpoint at 960px
- Scales display horizontally with flexbox
- Labels align properly on scale ends

**FR-005**: Form Validation
- Required field validation
- Proper HTML5 form validation
- Clear error indicators

**FR-006**: Submission Process
- Confirmation modal with customizable message
- Data saved to CSV file
- Timestamp recording (date + time)
- Prevention of duplicate submissions

### 2.3 Data Management
**FR-007**: Data Storage
- Single-line CSV entries per submission
- Automatic file creation if not exists
- Append-only data structure
- Timestamp columns (YYYY-MM-DD, HH-MM-SS)

**FR-008**: Results Display
- Question-by-question statistics
- Percentage calculations
- Horizontal bar visualizations
- Total response counts

### 2.4 Configuration & Customization
**FR-009**: Styling Customization
- Sans-serif typography
- Black and blue color scheme
- 1em base font size
- Minimal text hierarchy

**FR-010**: Survey Configuration
- Title and description support
- Separator elements
- Custom submit button text
- Confirmation messages

## 3. Non-Functional Requirements

### 3.1 Performance
**NFR-001**: Load time < 2 seconds on average connection
**NFR-002**: Support up to 10,000 responses per survey
**NFR-003**: Efficient CSV parsing for surveys up to 50 questions

### 3.2 Usability
**NFR-004**: Survey creation via CSV with minimal training
**NFR-005**: Mobile-friendly interface (touch targets > 44px)
**NFR-006**: Accessible form controls (ARIA labels where applicable)

### 3.3 Reliability
**NFR-007**: Graceful error handling for malformed CSV
**NFR-008**: File permission error messages
**NFR-009**: Data integrity through proper CSV escaping

### 3.4 Security
**NFR-010**: Input sanitization for CSV injection prevention
**NFR-011**: Basic XSS protection in displayed data
**NFR-012**: File write permissions handled securely

### 3.5 Compatibility
**NFR-013**: PHP 7.4+ compatibility
**NFR-014**: Cross-browser compatibility (Chrome, Firefox, Safari, Edge)
**NFR-015**: No JavaScript dependency for core functionality

## 4. Technical Specifications

### 4.1 File Structure
```
survey/
├── index.php          # Main survey page (HTML, CSS, PHP, JS)
├── results.php        # Results visualization
├── survey.csv         # Survey configuration (editor-created)
└── data.csv           # Response data (auto-generated)
```

### 4.2 CSV Specifications
**survey.csv columns:**
1. TYPE (Title, Description, Question, Answer, Separator, Submit, confirm)
2. CONTENT (text content or answer type)
3. REQUIRED (Yes/No)
4. NO ANSWER (Yes/No)
5. BEFORE (label for scale start)
6. AFTER (label for scale end)
7. MIN (minimum scale value)
8. MAX (maximum scale value)

**data.csv columns:**
1. Date (YYYY-MM-DD)
2. Time (HH-MM-SS)
3...n: Survey content and answers (matches survey.csv structure)

### 4.3 Design System
- **Typography**: System sans-serif, 1em base size
- **Colors**: #000000 (black), #0000ff (blue)
- **Spacing**: em-based units
- **Breakpoints**: 960px maximum width
- **Scale Display**: Flexbox with fractional distribution

## 5. Implementation Details

### 5.1 Core Components
1. **CSV Parser**: Reads survey structure and creates form
2. **Form Generator**: Dynamically creates HTML form elements
3. **Data Handler**: Processes submissions and saves to CSV
4. **Results Analyzer**: Calculates statistics from response data
5. **UI Components**: Modal, scales, responsive layouts

### 5.2 Error Handling
- Malformed CSV → Show descriptive error
- Write permissions → Clear permission error message
- Missing files → Graceful degradation
- Invalid submissions → Form validation feedback

## 6. Success Metrics

### 6.1 Usage Metrics
- Number of surveys created per month
- Average response rate per survey
- Survey completion rate

### 6.2 Performance Metrics
- Page load time (target < 2s)
- Form submission success rate (target > 99%)
- Error rate in CSV parsing (target < 1%)

### 6.3 User Satisfaction
- Editor setup time (target < 15 minutes)
- Respondent completion time
- Support request frequency

## 7. Future Enhancements (Roadmap)

### Phase 2 (v2.0)
- Multiple survey support in one installation
- Export results to Excel/PDF
- Basic data filtering in results view
- Survey preview mode

### Phase 3 (v3.0)
- Email notification on submission
- CSV import/export for survey templates
- Basic theming system
- Multi-language support

### Phase 4 (v4.0)
- Branching logic (conditional questions)
- Progress indicators
- Time limit on surveys
- Basic analytics dashboard

## 8. Assumptions & Constraints

### Assumptions
- Editors have basic CSV editing knowledge
- Server supports PHP 7.4+
- No database access required
- Surveys are public (no authentication needed)

### Constraints
- Maximum survey length: 50 questions (performance)
- Maximum responses: 10,000 per survey (file size)
- No user accounts or authentication
- No real-time collaboration

## 9. Dependencies
- PHP 7.4+ (no specific extensions required)
- Web server with write permissions
- Modern web browsers for respondents

## 10. Risk Assessment

| Risk | Impact | Mitigation |
|------|--------|------------|
| CSV injection attacks | High | Input sanitization, escaping |
| File permission issues | Medium | Clear error messages, documentation |
| Large file performance | Medium | Pagination in results, file size warnings |
| Browser compatibility | Low | Progressive enhancement, basic HTML forms |

---

*Document Version: 1.0*  
*Last Updated: April 2025*  
*Status: Approved for Implementation*
