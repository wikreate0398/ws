<html>
<head>
    <title><?=$theme?></title>
    <style type="text/css">

        @media screen and (max-width: 600px) {
            table[class="container"] {
                width: 95% !important;
            }
        }

        #outlook a {padding:0;}
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; font-family:Helvetica, Arial, sans-serif; color: #333;}
        .ExternalClass {width:100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
        #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
        img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        .image_fix {display:block;}
        p {margin: 1em 0;}
        h1, h2, h3, h4, h5, h6 {color: black !important;}

        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

        h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: red !important;
        }

        h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
            color: purple !important;
        }

        table td {border-collapse: collapse;}

        table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }

        a {color: #777;}

        @media only screen and (max-device-width: 480px) {

            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: black; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important; /* or whatever your want */
                pointer-events: auto;
                cursor: default;
            }
        }


        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: blue; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }

        @media only screen and (-webkit-min-device-pixel-ratio: 2) {
            /* Put your iPhone 4g styles in here */
        }

        @media only screen and (-webkit-device-pixel-ratio:.75){
            /* Put CSS for low density (ldpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1){
            /* Put CSS for medium density (mdpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1.5){
            /* Put CSS for high density (hdpi) Android layouts in here */
        }
        /* end Android targeting */
        h2{
            color:#181818;
            font-family:Helvetica, Arial, sans-serif;
            font-size:22px;
            line-height: 22px;
            font-weight: normal;
        }
        a.link1{

        }
        a.link2{
            color:#fff;
            text-decoration:none;
            font-family:Helvetica, Arial, sans-serif;
            font-size:16px;
            color:#fff;border-radius:4px;
        }
        p{
            color:#555;
            font-family:Helvetica, Arial, sans-serif;
            font-size:16px;
            line-height:24px;
        }

        .contentEditable{
            line-height:
        }
    </style>

</head>
<body>
<div style="margin:0; padding:10px; background-color:#fff;">
    <div style="width:100%; margin:0 auto; margin-top:10px; margin-bottom:10px; background-color:#fff; border-bottom:2px solid #D8D6D1;">

        <table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class='bgBody'>
            <tr>
                <td>
                    <table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->


                                <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
                                    <tr>
                                        <td class='movableContentContainer bgItem'>

                                            <!-- <div class='movableContent'>
                                                <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
                                                    <tr height="40">
                                                        <td width="200">&nbsp;</td>
                                                        <td width="200">&nbsp;</td>
                                                        <td width="200">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="600" valign="middle" align="left">
                                                            <div class="contentEditableContainer contentImageEditable">
                                                                <div class="contentEditable" style="background: rgba(0, 0, 0, .9); padding: 10px 15px; display: inline-block;" align='center' >
                                                                    <a href="<?=url('/')?>" target="_blank">
                                                                        <img src="<?=url('images/logo.png')?>" height="35"  alt='Logo'  data-default="placeholder" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr height="25">
                                                        <td width="200">&nbsp;</td>
                                                        <td width="200">&nbsp;</td>
                                                        <td width="200">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div> -->

                                            <div class='movableContent'>
                                                <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
                                                    <tr>
                                                        <td width="100%" colspan="3" align="center" style="padding-bottom:10px;padding-top:15px;">
                                                            <div class="contentEditableContainer contentTextEditable">
                                                                <div class="contentEditable" align='left' >
                                                                    <h2 style="margin: 0;"><?=$theme?></h2>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td width="100%" align="left">
                                                            <div class="contentEditableContainer contentTextEditable">
                                                                <div class="contentEditable" align='left' style="font-size: 14px; line-height: 22px;">
                                                                    <?=$msg?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <!-- <div class='movableContent'>
                                                <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container">
                                                    <tr>
                                                        <td width="100%" colspan="2" style="padding-top:35px;">
                                                            <hr style="height:1px;border:none;color:#333;background-color:#ddd;" />
                                                        </td>
                                                    </tr> 
                                                </table>
                                            </div> -->
                                            <br>
                                        </td>
                                    </tr>
                                </table>
                            </td></tr></table>
                </td>
            </tr>
        </table>

    </div>

</div>
</body>
</html>