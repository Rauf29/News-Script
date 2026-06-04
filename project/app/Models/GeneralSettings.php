<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $fillable = [
        'logo',
        'footer_logo',
		'lazy_baner',
		'og_baner',
        'favicon',
        'loader',
		'live_tv',
		'epaper_link',
        'admin_loader',
        'title',
        'theme_color',
        'footer_color',
		'sidebar_big_ads2',
		'sidebar_big_ads3',
		
		'phone2',
		'email2',
		'app1',
		'app2',
		
		
		
        'time_zone',
        'copyright_text',
		'sidebar_ads',
'header1_728',
'header2_728',
'header3_728',
'header4_728',
'adsense_code',
'search_console',
'homepageads1_970',
'homepageads2_970',
'homepageads3_970',
'homepageads4_970',

'sidebar_ads1',
'sidebar_adsbig',
		
		'dhaka',
		'ctg',
		'rajshahi',
		'khulna',
		'barishal',
		'syleth',
		'rangpur',
		'mymensingh',
		
		
		
		
		
		
		
		
		'adress',
		'email',
		'phone',
		
		'prokashok',
		'sompadok',
		'barta_sompadok',
		'notice_text',
        'facebook_page_url',
        'facebook_app_id',
		
		
        'copyright_color',
        'tags',
        'error_photo',
        'error_title',
		'horizontal_adds1',
        'error_text',
        'driver',
        'smtp_host',
        'smtp_port',
        'email_encryption',
        'smtp_user',
        'smtp_pass',
        'from_email',
        'from_name',
        'is_smtp',
        'is_verification_email',
        'version'
    ];
    protected $table    = 'generalsettings';
    public $timestamps  = false;
}
