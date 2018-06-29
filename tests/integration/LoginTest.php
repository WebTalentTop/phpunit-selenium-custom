<?php
/**
 * Integration tests for login functionality
 */
class LoginTest extends PHPUnit_Extensions_Selenium2TestCase
{

    /**
     * Defines which browsers are going to be tested
     * @var array
     */
    public static $browsers = array(
        array(
            "name" => "Chrome",
            "browserName" => "chrome",
        ),
        // array(
        //     "name" => "Firefox",
        //     "browserName" => "firefox",
        // ),
        // array(
        //     "name" => "Internet Exprlorer",
        //     "browserName" => "iexplore",
        // ),
    );

    /**
     * setup will be run for all our tests
     */
    protected function setUp()  {
        $this->setBrowserUrl(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_BASEURL);
        $this->setHost(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_HOST);

        $myClassReflection = new \ReflectionClass( get_class( $this->prepareSession() ) );
        $secret            = $myClassReflection->getProperty( 'stopped' );
        $secret->setAccessible( true );
        $secret->setValue( $this->prepareSession(), true );
    } // setUp()

    /**
     * Test that logins work
     *
     */
    public function testLoginSuccessful()  {
        $this->timeouts()->implicitWait(2000);
        $username = 'SCARLSON39';
        $password = 'LicorneTech1!';

        $this->url("https://sso.hhs.state.ma.us/oam/server/obrareq.cgi?encquery%3DHbFmFH0s53KuRvxkoCE%2F9OAqyADAQz7Ih8%2BnXfhsc0GOuWKKEdwIScTnF%2FfahjhjYVCRwn0MPE6ssHYWXkecWrhNa%2B%2BOhhD%2BTLWxR2ySV0gdGxfvLe%2FpRS6%2BfizTSn%2B6d8rtyb5rcknC%2BKX6PjJl%2F%2FoJzTu7%2FZ2aLjDZa0BjNR2toXDkmIu5sEeN4z16pglgZY4CnWP2AalQY1%2FezKijNB5Lw2VoV5Swr0zEHocq%2Fw5SIdbN8ohFWveq5UBFNKWPZ13J3S7JMt5WzzmGYmoII6vcJhtcxOOUVaVPBzr23xNpUaEJcaTPVeWV%2F%2Fvfbzu4DbYwO54MzMDrOi3plqhccxDfcE6vJ%2FP2K9MWkVE45e8%3D%20agentid%3Dwebgate1%20ver%3D1%20crmethod%3D2&ECID-Context=1.16736091039091636%3BkXhglfC");
        $usernameInput = $this->byName("username");
        $usernameInput->clear();
        $this->keys($username);

        $usernameInput = $this->byName("password");
        $usernameInput->clear();
        $this->keys($password);

        // $this->url("https://sso.hhs.state.ma.us/oam/server/auth_cred_submit");
        $form = current($this->elements($this->using('css selector')->value('form#loginData')));
        $form->submit();

        // -----Maximum allowed session reached!-----
        $MAXIMUM_SEESION_CONTEXT = 'The user has already reached the maximum allowed number of sessions. Please close one of the existing sessions before trying to login again.';
        $pMax = current($this->elements($this->using('css selector')->value('p#errorTxtAlignment')));

        if ($pMax)
        if ($pMax->text() == $MAXIMUM_SEESION_CONTEXT) {
            $this->assertEquals($MAXIMUM_SEESION_CONTEXT, $pMax->text());
            print '-----Maximum allowed session reached!-----';
        }
        // -------------------------------------------

        // -----Going to dispense page-----
        $marijuanaLink = $this->byLinkText("Medical Use of Marijuana System");
        // $marijuanaLink->click();

        $this->url("https://hhsvgapps01.hhs.state.ma.us/mmj-rmd/dispense/patient?id=11038157&lastName=Veeder");
        $ounces = current($this->elements($this->using('css selector')->value('span#ouncesRemaining')));
        $gramsRemaining = current($this->elements($this->using('css selector')->value('span#gramsRemaining')));
        
        print $ounces->text();
        print $gramsRemaining->text();

        // -----------------Github testing--------------------------

        // $username = 'webtalenttop  ';
        // $password = 'github123';

       
        // $this->url("https://github.com");
        // if (strpos( $this->byTag('body')->text(), "Sign up") == false) {
        //     print 'Singed in already';
        // } else {
        //     $this->url("https://github.com/login");
        //     $usernameInput = $this->byName("login");
        //     $usernameInput->clear();
        //     $this->keys($username);
        //     $usernameInput = $this->byName("password");
        //     $usernameInput->clear();
        //     $this->keys($password);
        //     $form = current($this->elements($this->using('css selector')->value('form')));
        //     $form->submit();
        // }

    } // testLoginSuccessful()

} //LoginTest class
