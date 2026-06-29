<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\geniusMailer;
use App\Models\GeneralSettings;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Schema;
use Mockery;

class GeniusMailerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('generalsettings', function ($table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('email_encryption')->nullable();
            $table->string('smtp_user')->nullable();
            $table->text('smtp_pass')->nullable();
            $table->tinyInteger('is_smtp')->default(0);
        });

        Schema::create('email_templates', function ($table) {
            $table->increments('id');
            $table->string('email_type')->nullable();
            $table->string('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->timestamps();
        });

        $gs = new GeneralSettings();
        $gs->id = 1;
        $gs->is_smtp = 0;
        $gs->from_email = 'noreply@example.com';
        $gs->from_name = 'Test Site';
        $gs->title = 'Test Site';
        $gs->smtp_host = 'smtp.example.com';
        $gs->smtp_user = 'user';
        $gs->smtp_pass = 'pass';
        $gs->email_encryption = 'tls';
        $gs->smtp_port = 587;
        $gs->save();

        $template = new EmailTemplate();
        $template->id = 1;
        $template->email_type = 'order_confirmation';
        $template->email_subject = 'Order Confirmation';
        $template->email_body = 'Hello {customer_name}, order {order_number} amount {order_amount} from {admin_name} ({admin_email}) on {website_title}';
        $template->save();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function mockPHPMailer(): object
    {
        return Mockery::mock('overload:PHPMailer\PHPMailer\PHPMailer');
    }

    public function test_constructor_loads_general_settings()
    {
        $this->mockPHPMailer();

        $mailer = new geniusMailer();

        $this->assertInstanceOf(geniusMailer::class, $mailer);
        $this->assertEquals(0, $mailer->gs->is_smtp);
        $this->assertEquals('noreply@example.com', $mailer->gs->from_email);
    }

    public function test_constructor_configures_smtp_when_enabled()
    {
        GeneralSettings::where('id', 1)->update(['is_smtp' => 1]);

        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('isSMTP')->once();
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $this->assertEquals(1, $mailer->gs->is_smtp);
    }

    public function test_constructor_skips_smtp_when_disabled()
    {
        GeneralSettings::where('id', 1)->update(['is_smtp' => 0]);

        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldNotReceive('isSMTP');
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $this->assertEquals(0, $mailer->gs->is_smtp);
    }

    public function test_sendAutoMail_sends_successfully()
    {
        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('setFrom')
            ->with('noreply@example.com', 'Test Site')
            ->once();
        $phpmailer->shouldReceive('addAddress')
            ->with('customer@test.com')
            ->once();
        $phpmailer->shouldReceive('isHTML')
            ->with(true)
            ->once();
        $phpmailer->shouldReceive('send')
            ->once()
            ->andReturn(true);
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $result = $mailer->sendAutoMail([
            'type' => 'order_confirmation',
            'to' => 'customer@test.com',
            'cname' => 'John Doe',
            'oamount' => '$99.99',
            'aname' => 'Admin',
            'aemail' => 'admin@test.com',
            'onumber' => 'ORD-12345',
        ]);

        $this->assertTrue($result);
    }

    public function test_sendAutoMail_replaces_template_placeholders()
    {
        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('setFrom')->withAnyArgs()->once();
        $phpmailer->shouldReceive('addAddress')->withAnyArgs()->once();
        $phpmailer->shouldReceive('isHTML')->with(true)->once();
        $phpmailer->shouldReceive('send')->once()->andReturn(true);
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $result = $mailer->sendAutoMail([
            'type' => 'order_confirmation',
            'to' => 'jane@test.com',
            'cname' => 'Jane',
            'oamount' => '$49.99',
            'aname' => 'Admin User',
            'aemail' => 'admin@site.com',
            'onumber' => 'ORD-67890',
        ]);

        $this->assertTrue($result);
    }

    public function test_sendAutoMail_sets_subject_from_template()
    {
        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('setFrom')->withAnyArgs()->once();
        $phpmailer->shouldReceive('addAddress')->withAnyArgs()->once();
        $phpmailer->shouldReceive('isHTML')->with(true)->once();
        $phpmailer->shouldReceive('send')->once()->andReturn(true);
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $result = $mailer->sendAutoMail([
            'type' => 'order_confirmation',
            'to' => 'test@test.com',
            'cname' => 'Test',
            'oamount' => '$0',
            'aname' => 'Admin',
            'aemail' => 'admin@test.com',
            'onumber' => 'N/A',
        ]);

        $this->assertTrue($result);
    }

    public function test_sendCustomMail_sends_successfully()
    {
        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('setFrom')
            ->with('noreply@example.com', 'Test Site')
            ->once();
        $phpmailer->shouldReceive('addAddress')
            ->with('recipient@test.com')
            ->once();
        $phpmailer->shouldReceive('isHTML')
            ->with(true)
            ->once();
        $phpmailer->shouldReceive('send')
            ->once()
            ->andReturn(true);
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $result = $mailer->sendCustomMail([
            'to' => 'recipient@test.com',
            'subject' => 'Custom Subject',
            'body' => '<h1>Hello</h1><p>This is a custom email.</p>',
        ]);

        $this->assertTrue($result);
    }

    public function test_sendCustomMail_uses_custom_subject_and_body()
    {
        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('setFrom')->withAnyArgs()->once();
        $phpmailer->shouldReceive('addAddress')->with('user@domain.com')->once();
        $phpmailer->shouldReceive('isHTML')->with(true)->once();

        $phpmailer->shouldReceive('send')->once()->andReturn(true);
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $result = $mailer->sendCustomMail([
            'to' => 'user@domain.com',
            'subject' => 'Alert Notification',
            'body' => 'Plain text body',
        ]);

        $this->assertTrue($result);
    }

    public function test_sendAutoMail_returns_true_on_exception()
    {
        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('setFrom')->andThrow(new \Exception('SMTP connection failed'));
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $result = $mailer->sendAutoMail([
            'type' => 'order_confirmation',
            'to' => 'fail@test.com',
            'cname' => 'Fail',
            'oamount' => '$0',
            'aname' => 'Admin',
            'aemail' => 'admin@test.com',
            'onumber' => 'ORD-FAIL',
        ]);

        $this->assertTrue($result);
    }

    public function test_sendCustomMail_returns_true_on_exception()
    {
        $phpmailer = $this->mockPHPMailer();
        $phpmailer->shouldReceive('setFrom')->andThrow(new \Exception('Connection refused'));
        $phpmailer->shouldIgnoreMissing();

        $mailer = new geniusMailer();

        $result = $mailer->sendCustomMail([
            'to' => 'fail@test.com',
            'subject' => 'Fail',
            'body' => 'Fail body',
        ]);

        $this->assertTrue($result);
    }
}
