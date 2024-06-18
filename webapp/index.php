<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SSL Checker</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/supersized.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/theme/supersized.shutter.css" type="text/css" media="screen" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script>
<script type="text/javascript" src="js/supersized.3.2.7.min.js"></script>
<script type="text/javascript" src="css/theme/supersized.shutter.min.js"></script>
<script type="text/javascript">
    /**
     * This script initializes the Supersized jQuery plugin to create a slideshow.
     * It sets various options for the slideshow, such as slide interval, transition type, and transition speed.
     * It also defines the slideshow images with their corresponding titles, thumbnails, and URLs.
     *
     * @link https://github.com/buildinternet/supersized
     */

    // Call the function on page load
    $(document).ready(function() {
        initializeBackgroundSlideshow();
    });

    function initializeBackgroundSlideshow() {
        jQuery(function($){
            $.supersized({
                // Functionality
                slide_interval 	: 18000,		// Length between transitions
                transition 		: 1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                transition_speed : 22000,		// Speed of transition
                random		     : 'true',
                // Components
                slide_links	: 'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
                slides 		: [			// Slideshow Images
                    {image : './img/everything-everything.jpg', title : 'everything-everything', thumb : '', url : ''},
                    {image : './img/kraftwerk_electric_cafe_ab-1280.jpg', title : 'elektric cafe', thumb : '', url : ''},
                    {image : './img/alpen.jpg', title : 'alpen', thumb : '', url : ''},
                    {image : './img/koyaanisqatsi-1982-003.jpg', title : 'koyaanisqatsi-1982-003', thumb : '', url : ''},
                    {image : './img/koyaanisqatsi-1982-001.jpg', title : 'koyaanisqatsi-1982-001', thumb : '', url : ''},
                    {image : './img/satellite-dish.jpg', title : 'satellite-dish', thumb : '', url : ''},
                    {image : './img/naqoyqatsi-8.jpg', title : 'naqoyqatsi', thumb : '', url : ''},
                    {image : './img/naqoyqatsi-3.jpg', title : 'naqoyqatsi', thumb : '', url : ''},
                    {image : './img/naqoyqatsi.jpg', title : 'naqoyqatsi', thumb : '', url : ''},
                    {image : './img/qatsi-cars.jpg', title : 'qatsi-cars', thumb : '', url : ''},
                ]
            });
        });
    }
</script>
</head>
<body>
<div class='content'>
    <div class="container">
        <h1>SSL Checker</h1>
        <!-- Container where the SSL certificate data will be displayed -->
        <div id="sslDataContainer"></div>
        <!-- The form for domain input -->
        <form id="sslForm">
        <label for="domain">Enter a domain name to check its SSL certificate information</label>
            <input type="text" id="domain" name="domain" placeholder="Enter domain name, i.e. example.com">
            <button type="submit">Check SSL</button>
        </form>
    </div>
</div>
<script>
/**
 * This script handles the form submission for SSL check.
 * It intercepts the form submission event, sends an AJAX request to the server,
 * and displays the SSL data in a table format on the web page.
 *
 * @filesource ssl-check/webapp/index.php
 * @package SSLCheck
 */

$(document).ready(function() {
    console.log("jQuery loaded");

    /**
     * Intercept the form submission event and handle it.
     */
    $('#sslForm').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting through the browser
        console.log("Form submission intercepted");

        // Get the domain from the input
        var domain = $('#domain').val();
        console.log("Domain: ", domain);

        // Send an AJAX request to the server
        $.ajax({
            type: "POST",
            url: "./ssl_check.php", // Ensure this URL is correct
            data: { domain: domain },
            dataType: "json", // Expecting JSON response
            success: function(response) {
                if (response && response.data) {
                    var content = '<p>' + response.message + '</p>';
                    var table = '<table class="ssl-data-table"><tbody>';

                    // Define keys you want to display, including nested keys
                    var keysToInclude = [
                        'name', 
                        'subject', 
                        'hash', 
                        'issuer', 
                        'version', 
                        'serialNumber', 
                        'serialNumberHex', 
                        'validFrom_time_t', 
                        'validTo_time_t', 
                        'signatureTypeSN', 
                        'signatureTypeLN', 
                        'signatureTypeNID', 
                        'extensions'
                    ];

                    // Define a mapping of technical keys to user-friendly names
                    var keyNameMapping = {
                        'name': 'Name',
                        'subject': 'Subject',
                        'hash': 'Hash',
                        'issuer': 'Issuer',
                        'version': 'Version',
                        'serialNumber': 'Serial Number',
                        'serialNumberHex': 'Serial Number (Hex)',
                        'validFrom_time_t': 'Valid From',
                        'validTo_time_t': 'Valid To',
                        'signatureTypeSN': 'Signature Type (SN)',
                        'signatureTypeLN': 'Signature Type (LN)',
                        'signatureTypeNID': 'Signature Type (NID)',
                        'extensions': 'Extensions',
                        'C': 'Country',
                        'ST': 'State',
                        'L': 'Locality',
                        'O': 'Organization',
                        'OU': 'Organizational Unit',
                        'CN': 'Common Name',
                        'emailAddress': 'Email Address',
                        'subjectAltName': 'Subject Alternative Name',
                        'subjectKeyIdentifier': 'Subject Key Identifier',
                        'authorityKeyIdentifier': 'Authority Key Identifier',
                        'keyUsage': 'Key Usage',
                        'extendedKeyUsage': 'Extended Key Usage',
                        'authorityInfoAccess': 'Authority Information Access',
                        'crlDistributionPoints': 'CRL Distribution Points',
                        'basicConstraints': 'Basic Constraints',
                        'certificatePolicies': 'Certificate Policies',
                        'ct_precert_scts': 'CT Precertificate SCTs', 
                    };
                    
                    /**
                     * Process a key-value pair recursively and generate the table rows.
                     *
                     * @param {string} key - The key of the pair.
                     * @param {mixed} value - The value of the pair.
                     * @param {number} depth - The depth of the nested object.
                     */
                    function processKeyValue(key, value, depth) {
                        // Check if the key is in the whitelist or if we're processing nested objects
                        if (keysToInclude.includes(key) || depth > 0) {
                            if (typeof value === 'object' && value !== null) {
                                // For nested objects, add a row for the key, then process each sub-key
                                // Use the user-friendly name from the mapping, if available
                                var displayName = keyNameMapping[key] || key;
                                table += `<tr><td colspan="2">${displayName}</td></tr>`;
                                Object.entries(value).forEach(([subKey, subValue]) => {
                                    processKeyValue(subKey, subValue, depth + 1);
                                });
                            } else {
                                // Check if the key is a Unix timestamp field
                                if (key === 'validFrom_time_t' || key === 'validTo_time_t') {
                                    // Convert Unix timestamp to a human-readable date-time string
                                    const date = new Date(value * 1000);
                                    // Example: Custom formatting for U.S. English
                                    const options = {
                                        weekday: 'long', // e.g., Thursday
                                        year: 'numeric', // e.g., 2023
                                        month: 'long', // e.g., January
                                        day: 'numeric', // e.g., 1
                                        hour: '2-digit', // e.g., 02
                                        minute: '2-digit', // e.g., 05
                                        second: '2-digit', // e.g., 07
                                        timeZoneName: 'short' // e.g., EST
                                    };
                                    const dateString = date.toLocaleString('en-US', options); // Converts to local date-time string
                                    var displayName = keyNameMapping[key] || key; // Use the user-friendly name
                                    table += `<tr><td>${displayName}</td><td>${dateString}</td></tr>`;
                                } else {
                                    // For simple key-value pairs, add a row with the key and value
                                    // Use the user-friendly name from the mapping, if available
                                    var displayName = keyNameMapping[key] || key;
                                    table += `<tr><td>${displayName}</td><td>${value}</td></tr>`;
                                }
                            }
                        }
                    }

                    // Process each key-value pair in the response data
                    Object.entries(response.data).forEach(([key, value]) => {
                        processKeyValue(key, value, 0); // Start with depth 0
                    });

                    table += '</tbody></table>';
                    content += table;

                    // Display the SSL data on the web page
                    $('#sslDataContainer').html(content).show();
                }
            },
            error: function(xhr, status, error) {
                console.log("Error: ", status, error);
                $('#sslDataContainer').html('<p>An error occurred while fetching SSL data.</p>');
            }
        });
    });
});
</script>
</body>
</html>