<?php

use Faker\Factory;
use voku\helper\EmailCheck;

/**
 * MailCheckTest
 *
 * - https://isemail.info/_system/is_email/test/?all
 */
class EmailCheckTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var EmailCheck
   */
  protected $validator;

  protected function setUp()
  {
    $this->validator = new EmailCheck();
  }

  protected function tearDown()
  {
    $this->validator = null;
  }

  public function testCheckEmail()
  {
    $idnToAsciiFunctionExists = function_exists('idn_to_ascii');

    $testArrayOk = array(
        'sdsaaluzbr70l@a5k-nig8t2.com',
        'b25m_7m@amaaxtyy.com',
        'xktpwt4611mpb2r@2s2znczzc.com',
        'xo.w8w8o.q84@itpu9rkn.com',
        'f9fhx@5kle7zeruzl.com',
        '34q_l8ujm6xtw4@p10ätilyez.com',
        'us9rgyhwxtqe3@29njsdyiby.com',
        'aqp_i_t28-8t@eqdx7in.com',
        '39z7v99iyfh@ctfksxz.com',
        '792k.nf@h13nqxajg.com',
        'pukwx639mo82-2@vx-u-e.com',
        '9eeueo2auev6@zfwpb948x2.com',
        'px4o3ucyyhg@2v73d-l.com',
        'stdtr0qdzblbyc@pnvraiyg-i.com',
        'mbc@h1uz5be1qhn.com',
        'pew6tgktp@9zng2er4g.com',
        '3nn5scj2q3i@564xm086n.com',
        '3.k7sbafv4t9u@a03yös7hm.com',
        '1z2uavb3vlv@anvf8mx56x3.com',
        'fehmr8fet8y@spyi0-40.com',
        'ej24cvo@5gz0l6l2.com',
        '8imt33g_1g4y@se225ü4o7.comv',
        'vx8q9yfnsoz@adofccl5z.com',
        'rv5-ng7.3owx6@ri95zlrzp66s.com',
        'mx_kbtc.8i67_h@pu-7391.com',
        'hgzb.f-fr@td1vw3u.com',
        'ok-v1tvw@krk21r8ms8rq.com',
        'afz@u2qegprqnbf7.com',
        'fca05s6e_2@wo2to8g9xxc.com',
        'vkqwqlgfrjfna@t-online.de.com',
        'first.last@iana.org',
        '1234567890123456789012345678901234567890123456789012345678901234@iana.org',
        'first.last@3com.com',
        'first.last@123.iana.org',
        'user+mailbox@iana.org',
        'customer/department=shipping@iana.org',
        '$A12345@iana.org',
        '!def!xyz%abc@iana.org',
        '_somename@iana.org',
        'dclo@us.ibm.com',
        'first.last@iana.org',
        'test@iana.org',
        'TEST@iana.org',
        '1234567890@iana.org',
        'test+test@iana.org',
        'test-test@iana.org',
        't*est@iana.org',
        '+1~1+@iana.org',
        '{_test_}@iana.org',
        'test.test@iana.org',
        'test@example.iana.org',
        'test@example.example.iana.org',
        'customer/department@iana.org',
        '_Lall.Sam@iana.org',
        '~@iana.org',
        'a@bar.com',
        'a-b@bar.com',
        '+@b.com',
        'a@b.co-foo.uk',
        'valid@about.museum',
        //"foobar@192.168.0.1",
        'user%uucp!path@berkeley.edu',
        "cdburgess+!#$%&'*-/=?+_{}|~test@gmail.com",
        'test@xn--example.com',
        'foobar.66540@web.de',
        'fdsfsd@☺fdsvsdfesf.de',
        'fodsadsaobar@ŧ-online.de',
        'aluzbö70l@a5k-nig8t2.com',
        '8imt§3g_1g4y@se§25ü4o7.comv',
        'tworzenieweb+hans.müller@gmail.com',
    );

    $testArrayFail = array(
        'test@test.com',
        'test@example.com',
        '@amaaxtyy.com',
        'xktpwt4611mpb2r@.com',
        'xo.w8w8o.q84@itpu9rkn.',
        'f9fhx@#.com',
        '@p10ätilyez.com',
        'us9rgyhwxtqe3@-.com',
        'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa@foobar.com',
        'aqp_i_t28-8t@hjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfh.hjfghfghfghgfh',
        '  @ctfksxz.com',
        '792k.nf@ .com',
        'pukwx639mo82-2@vx-u-e. ',
        ' ',
        'hjfghfghfghgfhhjfghfghfghgfhhjfghfghfghhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfh@2v73d-l.com',
        'stdtr0qdzblbyc@#-i.com',
        'mbc@h1uz5be1#hn.com',
        'pew6tgktp@9zn%2er4g.com',
        '3nn5scj2q3i@564x&086n.com',
        '3.k7sbafv4t9u@a03(ös7hm.com',
        '1z2uavb3vlv@anvf)mx56x3.com',
        'fehmr8(et8y@spyi0-40.com',
        'ej24)vo@5gz0l6l2.com',
        'vx8q!!!###yfnsoz@adofccl5z:a',
        'rv5-ng7.3owx6@com',
        'mx_kbtc.8i67_h@pu-7391.',
        'hgzb.f-fr@-tonline.de',
        'ok-v1tvw@aecor.de',
        'afz@al.com',
        'fca05s6e_2@-online.de',
        'vkqwqlgfrjfna@+++,com',
        'foobsadar%40live.de',
    );

    self::assertSame(false, EmailCheck::isValid(''));

    $email = 'lall';
    self::assertSame(false, EmailCheck::isValid($email, true, true, true, false), $email);

    $email = 'lall.öäü.de';
    self::assertSame(false, EmailCheck::isValid($email, true, true, true, false), $email);

    $email = 'test@-tonline.de.de';
    self::assertSame(false, EmailCheck::isValid($email, true, true, true, false), $email);

    $email = 'lars@moelleken.org';
    self::assertSame(true, EmailCheck::isValid($email, true, true, true, false), $email);

    $email = 'Lars@Moelleken.ORG';
    self::assertSame(true, EmailCheck::isValid($email, true, true, true, false), $email);

    $email = 'Lars@Mölleken.ORG';
    self::assertSame(true, EmailCheck::isValid($email, true, true, true, false), $email);

    $email = 'Lars@MÖlleken.ORG';
    self::assertSame(true, EmailCheck::isValid($email, true, true, true, false), $email);

    if ($idnToAsciiFunctionExists === true) {
      $email = 'Lars@Môelléken.org';
      self::assertSame(true, EmailCheck::isValid($email, true, true, true, false), $email);
    }

    foreach ($testArrayOk as $email) {
      self::assertSame(true, EmailCheck::isValid($email, true, true, true, false), $email);
    }

    foreach ($testArrayFail as $email) {
      self::assertSame(false, EmailCheck::isValid($email, true, true, true, false), $email);
    }
  }

  public function testIsDnsError()
  {
    $testArrayFalse = array(
        'dsadsadasdvgffdee-foo.de',
        'ääääääöüüüüüüfoo.com',
    );

    foreach ($testArrayFalse as $domain) {
      self::assertSame(true, EmailCheck::isDnsError($domain), $domain);
    }

    $testArrayTrue = array(
        'gmail.com',
        'aol.com',
    );

    foreach ($testArrayTrue as $domain) {
      self::assertSame(false, EmailCheck::isDnsError($domain), $domain);
    }
  }

  public function testIsTemporaryDomain()
  {
    $testArrayFalse = array(
        'gmail.com',
        'aol.com',
    );

    foreach ($testArrayFalse as $domain) {
      self::assertSame(false, EmailCheck::isTemporaryDomain($domain), $domain);
    }

    $testArrayTrue = array(
        '10minutemail.com',
        '20minutemail.com',
    );

    foreach ($testArrayTrue as $domain) {
      self::assertSame(true, EmailCheck::isTemporaryDomain($domain), $domain);
    }
  }

  public function testIsTypoInDomain()
  {
    $testArrayFalse = array(
        'gmail.com',
        'aol.com',
    );

    foreach ($testArrayFalse as $domain) {
      self::assertSame(false, EmailCheck::isTypoInDomain($domain), $domain);
    }

    $testArrayTrue = array(
        'aol.con',
        'ao.com',
    );

    foreach ($testArrayTrue as $domain) {
      self::assertSame(true, EmailCheck::isTypoInDomain($domain), $domain);
    }
  }

  public function testPerformance()
  {
    $iterations = 2000;

    $testingMail = 'example@example.com';
    echo 'Testing ' . $iterations . ' iterations with ' . $testingMail . PHP_EOL;

    // ---

    $isValid = array();
    $a = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
      $isValid[] = filter_var($testingMail, FILTER_VALIDATE_EMAIL);
    }
    $b = microtime(true);
    self::assertEquals(false, in_array(false, $isValid, true));
    echo($b - $a) . ' seconds with filter_var' . PHP_EOL;

    // ---

    $isValid = array();
    $a = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
      $isValid[] = EmailCheck::isValid($testingMail);
    }
    $b = microtime(true);
    self::assertEquals(false, in_array(false, $isValid, true));
    echo($b - $a) . ' seconds with EmailCheck' . PHP_EOL;

    // ---
  }

  public function testIsEmailExample()
  {
    // Not valid
    self::assertFalse(EmailCheck::isValid('example.com', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example@example', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example[AT]example.com', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example@example.com', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example+label@example.com', true, false, false, false));

    // Valid
    self::assertTrue(EmailCheck::isValid('example+label@diesisteintest.de', true, false, false, false));
  }

  public function testIsMailViaFaker()
  {
    $faker = Factory::create();

    for ($i = 0; $i < 1000; $i++) {
      $name = $faker->firstName; // e.g.: 'Joe'
      self::assertFalse(EmailCheck::isValid($name), $name);

      $email = $faker->email; // e.g.: 'tkshlerin@collins.com'
      self::assertTrue(EmailCheck::isValid($email), $email);

      $freeEmail = $faker->freeEmail; // e.g.: 'bradley72@gmail.com'
      self::assertTrue(EmailCheck::isValid($freeEmail), $freeEmail);

      $companyEmail = $faker->companyEmail; // e.g.: 'russel.durward@mcdermott.org'
      self::assertTrue(EmailCheck::isValid($companyEmail), $companyEmail);

      $safeEmail = $faker->safeEmail; // e.g.: 'king.alford@example.org'
      self::assertTrue(EmailCheck::isValid($safeEmail, false, true, true, false), $safeEmail);
    }
  }

  /**
   * @dataProvider getValidEmails
   *
   * @param $email
   */
  public function testValidEmails($email)
  {
    /** @noinspection StaticInvocationViaThisInspection */
    self::assertTrue($this->validator->isValid($email), 'tested: ' . $email);
  }

  public function testInvalidUTF8Email()
  {
    $validator = new EmailCheck();
    $email = "\x80\x81\x82@\x83\x84\x85.\x86\x87\x88";
    /** @noinspection StaticInvocationViaThisInspection */
    self::assertFalse($validator->isValid($email));
  }

  /**
   * @return array
   */
  public function getValidEmails()
  {
    return array(
        array('!#$%&`*+/=?^`{|}~@iana.org'),
        array('test@io.io'),
        array('â@iana.org'),
        array('contato@myemail.com.br'),
        array('fabien@symfony.com'),
        array('example@example.co.uk'),
        array('fabien_potencier@example.fr'),
        array('fab\'ien@symfony.com'),
        array('example@fakedfake.co.uk'),
        array('example@faked.fake.co.uk'),
        array('fabien+@symfony.com'),
        array('инфо@письмо.рф'),
        array('"username"@example.com'),
        array('"user,name"@example.com'),
        array('"user+name"@example.com'),
        array('fab\ ien@symfony.com'),
        array('"user name"@example.com'),
        array('"test\ test"@iana.org'),
        array('test@[255.255.255.255]'),
        array('test@[IPv6:1111:2222:3333:4444:5555:6666:7777:8888]'),
        array('!#$%&`*+/=?^`{|}~@[IPv6:1111:2222:3333:4444::255.255.255.255]'),
        array('foobar@foobar.foo.ws'),
        array('武＠メール.グーグル'),
        array('foobar@😍🎻😸🎩🎱🎮🍟🐝.🍕💩.ws'),
        array('"user@name"@example.com'),
        array('"\a"@iana.org'),
        array('""@iana.org'),
        array('"\""@iana.org'),
        array('müller@möller.de'),
        array('m.üller@möller.de'),
        array('"meuller m"@möller.de'),
        array('"müller m"@möller.de'),
        array('test@email.com.au'),
        array('123@iana.org'),
        array('test@123.com'),
        array('abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghiklm@iana.org'),
        array('test@xn--hxajbheg2az3al.xn--jxalpdlp'),
    );
  }

  /**
   * @dataProvider getInvalidEmails
   *
   * @param $email
   */
  public function testInvalidEmails($email)
  {
    /** @noinspection StaticInvocationViaThisInspection */
    self::assertFalse($this->validator->isValid($email), 'tested: ' . $email);
  }

  /**
   * @return array
   */
  public function getInvalidEmails()
  {
    return array(
        array(''), // Address has no domain part
        array('test'), // Address has no domain part
        array('@'), // Address has no local part
        array('test@'), // Address has no domain part
        array('@iana.org'), // Address has no local part
        array('.test@iana.org'), // Neither part of the address may begin with a dot
        array('test.@iana.org'), // Neither part of the address may end with a dot
        array('test..iana.org'), // The address may not contain consecutive dots
        array('test\@test@iana.org'), // Address contains a character that is not allowed
        array('test@a[255.255.255.255]'), // Address contains a character that is not allowed
        array('test@[255.255.255]'), // The domain literal is not a valid RFC 5321 address literal
        array('test@[255.255.255.255.255]'), // The domain literal is not a valid RFC 5321 address literal
        array('test@[255.255.255.256]'), // The domain literal is not a valid RFC 5321 address literal
        array('test@[1111:2222:3333:4444:5555:6666:7777:8888]'),
        array('test@[IPv6:1111:2222:3333:4444:5555:6666:7777]'),
        array('test@[IPv6:1111:2222:3333:4444:5555:6666:7777:8888:9999]'),
        array('test@[IPv6:1111:2222:3333:4444:5555:6666:7777:888G]'),
        array('test@email*'),
        array('test@email!'),
        array('test@email&'),
        array('test@email^'),
        array('test@email%'),
        array('test@email$'),
        array('test@example.com test'),
        array('user  name@example.com'),
        array('user   name@example.com'),
        array('example.@example.co.uk'),
        array('example@example@example.co.uk'),
        array('(test_exampel@example.fr)'),
        array('example(example)example@example.co.uk'),
        array('example@localhost'), // RFC5321
        array('.example@localhost'),
        array('ex\ample@localhost'),
        array('example@local\host'),
        array('example@localhost.'),
        array('user name@example.com'),
        array('username@ example . com'),
        array('example@(fake).com'),
        array('example@(fake.com'),
        array('username@example,com'),
        array('usern,ame@example.com'),
        array('user[na]me@example.com'),
        array('"""@iana.org'),
        array('"\"@iana.org'),
        array('"\ "@i\ ana.org'),
        array('"\\"@iana.org'),
        array('"test"test@iana.org'),
        array('"test""test"@iana.org'),
        array('"test"."test"@iana.org'),
        array('"test".test@iana.org'),
        array('fab\  ien@symfony.com'), // with escaped space + extra invalid space
        array('"user   ""name"@example.com'), // with quote spaces + invalid quotes
        array('"test"\ "test"@iana.org'), // invalid quotes
        array('"test"\ + "test"@iana.org'), // invalid quotes v2
        array('"test"' . chr(0) . '@iana.org'),
        array('"test\"@iana.org'),
        //array(chr(226) . '@iana.org'), // TODO?
        array('test@' . chr(226) . '.org'),
        array('\r\ntest@iana.org'),
        array('\r\n test@iana.org'),
        array('\r\n \r\ntest@iana.org'),
        array('\r\n \r\ntest@iana.org'),
        array('\r\n \r\n test@iana.org'),
        array('test@iana.org \r\n'),
        array('test@iana.org \r\n '),
        array('test@iana.org \r\n \r\n'),
        array('test@iana.org \r\n\r\n'),
        array('test@iana.org  \r\n\r\n '),
        array("\r\ntest@iana.org"),
        array("\r\n test@iana.org"),
        array("\r\n \r\ntest@iana.org"),
        array("\r\n \r\ntest@iana.org"),
        array("\r\n \r\n test@iana.org"),
        array("test@iana.org \r\n"),
        array("test@iana.org \r\n "),
        array("test@iana.org \r\n \r\n"),
        array("test@iana.org \r\n\r\n"),
        array("test@iana.org  \r\n\r\n "),
        array('test@foo;bar.com'),
        array('test;123@foobar.com'),
        array('test@example..com'),
        array('email.email@email."'),
        array('test@email>'),
        array('test@email<'),
        array('test@email{'),
        array('test@email.com]'),
        array('test@ema[il.com'),
    );
  }

  /**
   * @dataProvider getInvalidEmailsWithDnsCheck
   *
   * @param $email
   */
  public function testInvalidEmailsWithDnsCheck($email)
  {
    /** @noinspection StaticInvocationViaThisInspection */
    self::assertFalse($this->validator->isValid($email, false, false, false, true), 'tested: ' . $email);
  }

  /**
   * @return array
   */
  public function getInvalidEmailsWithDnsCheck()
  {
    return array(
        array('example@dfsdfsdfdsfsdfsdf.co.uk',),
        array('example@ dfsdfsdfdsfsdfsdf.co.uk',),
        array('example@example(examplecomment).co.uk',),
        array('example(examplecomment)@example.co.uk',),
        array("\"\t\"@dfsdfsdfdsfsdfsdf.co.uk",),
        array("\"\r\"@dfsdfsdfdsfsdfsdf.co.uk",),
        array('example@[IPv6:2001:0db8:85a3:0000:0000:8a2e:0370:7334]',),
        array('example@[IPv6:2001:0db8:85a3:0000:0000:8a2e:0370::]',),
        array('example@[IPv6:2001:0db8:85a3:0000:0000:8a2e:0370:7334::]',),
        array('example@[IPv6:1::1::1]',),
        array("example@[\n]",),
        array('example@[::1]',),
        array('example@[::123.45.67.178]',),
        array('example@[IPv6::2001:0db8:85a3:0000:0000:8a2e:0370:7334]',),
        array('example@[IPv6:z001:0db8:85a3:0000:0000:8a2e:0370:7334]',),
        array('example@[IPv6:2001:0db8:85a3:0000:0000:8a2e:0370:]',),
        array('"example"@dfsdfsdfdsfsdfsdf.co.uk',),
        array('too_long_localpart_too_long_localpart_too_long_localpart_too_long_localpart@dfsdfsdfdsfsdfsdf.co.uk',),
        array('example@toolonglocalparttoolonglocalparttoolonglocalparttoolonglocalpart.co.uk',),
        array(
            'example@toolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocal' .
            'parttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalpart' .
            'toolonglocalparttoolonglocalparttoolonglocalparttoolonglocalpart',
        ),
        array(
            'example@toolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocal' .
            'parttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalparttoolonglocalpart' .
            'toolonglocalparttoolonglocalparttoolonglocalparttoolonglocalpar',
        ),
        array('test@test',),
        array('"test"@test',),
    );
  }
}
