<?php

namespace Lii\IP;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\IP\IPValidator;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IPController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
//     public function initialize() : void
//     {
//         // Use to initialise member variables.
//         $this->db = "active";
//     }


    /**
     * This is how a general helper method can be created in the controller.
     *
     * @param string $method as the method that handled the controller
     *                       action.
     * @param array  $args   as an array of arguments.
     *
     * @return string as a message to output to help understand how the
     *                controller method works.
     */
    private function getDetailsOnRequest(string $method, array $args = []) : string
    {
        $request     = $this->di->get("request");
        $router      = $this->di->get("router");
        $path        = $request->getRoute();
        $httpMethod  = $request->getMethod();
        $mount       = rtrim($router->getLastRoute(), "/");
        $numArgs     = count($args);
        $strArgs     = implode(", ", $args);
        $queryString = http_build_query($request->getGet(), '', ', ');

        return <<<EOD
            <h1>$method</h1>

            <p>The controller mountpoint is '$mount'.
            <p>The request was '$path' ($httpMethod).
            <p>Got '$numArgs' arguments: '$strArgs'.
            <p>Query string contains: '$queryString'.
            <p>\$db is '{$this->db}'.
        EOD;
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $page->add("Lii/iptest");

        return $page->render([
            "title" => __METHOD__,
        ]);
    }

    /**
     * This is the validate method action, it handles:
     * POST METHOD mountpoint/validate
     *
     * @return object
     */
    public function validateActionPost() : object
    {
        $request = $this->di->get("request");
        $inputIP = $request->getPost("ip");

        $validator = new IPValidator();
        $validationResultIPv4 = $validator->validateIPv4($inputIP);
        $validationResultIPv6 = $validator->validateIPv6($inputIP);
        $domain = $validator->checkDomain($inputIP);

        $page = $this->di->get("page");
        $data = [
            "ip" => $inputIP,
            "resultIPv4" => $validationResultIPv4,
            "resultIPv6" => $validationResultIPv6,
            "domain" => $domain,
        ];
        $page->add("Lii/ipresult", $data);

        return $page->render([
            "title" => __METHOD__,
        ]);
    }


    /**
     * This sample method dumps the content of $di.
     * GET mountpoint/dump-app
     *
     * @return string
     */
//     public function dumpDiActionGet() : string
//     {
//         // Deal with the action and return a response.
//         $services = implode(", ", $this->di->getServices());
//         return __METHOD__ . "<p>\$di contains: $services";
//     }



    /**
     * Add the request method to the method name to limit what request methods
     * the handler supports.
     * GET mountpoint/info
     *
     * @return string
     */
//     public function infoActionGet() : string
//     {
//         // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}";
//     }



    /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
//     public function createActionGet() : string
//     {
//         // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}";
//     }



    /**
     * This sample method action it the handler for route:
     * POST mountpoint/create
     *
     * @return string
     */
//     public function createActionPost() : string
//     {
//         // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}";
//     }



    /**
     * This sample method action takes one argument:
     * GET mountpoint/argument/<value>
     *
     * @param mixed $value
     *
     * @return string
     */
//     public function argumentActionGet($value) : string
//     {
//         // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
//     }



    /**
     * This sample method action takes zero or one argument and you can use - as a separator which will then be removed:
     * GET mountpoint/defaultargument/
     * GET mountpoint/defaultargument/<value>
     * GET mountpoint/default-argument/
     * GET mountpoint/default-argument/<value>
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
//     public function defaultArgumentActionGet($value = "default") : string
//     {
//         // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
//     }



    /**
     * This sample method action takes two typed arguments:
     * GET mountpoint/typed-argument/<string>/<int>
     *
     * NOTE. Its recommended to not use int as type since it will still
     * accept numbers such as 2hundred givving a PHP NOTICE. So, its better to
     * deal with type check within the action method and throuw exceptions
     * when the expected type is not met.
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
//     public function typedArgumentActionGet(string $str, int $int) : string
//     {
//         // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}, got string argument '$str' and int argument '$int'.";
//     }



    /**
     * This sample method action takes a variadic list of arguments:
     * GET mountpoint/variadic/
     * GET mountpoint/variadic/<value>
     * GET mountpoint/variadic/<value>/<value>
     * GET mountpoint/variadic/<value>/<value>/<value>
     * etc.
     *
     * @param array $value as a variadic parameter.
     *
     * @return string
     */
//     public function variadicActionGet(...$value) : string
//     {
//         // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value);
//     }



    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        $page = $this->di->get("page");
        $data = [
            "content" => $this->getDetailsOnRequest(__METHOD__, $args),
        ];
        $page->add("Lii/default", $data);

        return $page->render([
            "title" => __METHOD__,
        ]);
    }
}
