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
                  {image : 'https://ssl-check.76games.io/img/195c8e0b3fcb2101b6ca0f02e9ba44b0.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/63923308b6ff377f22eb9b1e95976ed2.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/b6df4f7c518db4a2ad469ce192b19f4e.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/54aaa216ce9197179d8713d76e9d036c.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/8128ff7ca857daa8fe622a7893454bf0.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/be456e609897237c04e9e930e9299299.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/f6d9e897f34ecbec5a516dd5e0360178.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/62245a04acae62e88c6ece15a42b451b.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/8138caa05ac45dc6073cd063a72e7abc.jpg', title : '', thumb : '', url : ''},
                  {image : 'https://ssl-check.76games.io/img/c1013e8f23a404a1e537db1183444c74.jpg', title : '', thumb : '', url : ''},
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
            url: "ssl_check.php", // Ensure this URL is correct
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
                                table += `<tr><td colspan="2" style="padding-left:20px">${displayName}</td></tr>`;
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
