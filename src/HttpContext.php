<?php

namespace N1215\Http\Context\Sample;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use N1215\Http\Context\HttpContextInterface;
use N1215\Http\Context\HttpHandlerInterface;

/**
 * Class HttpContext
 */
class HttpContext implements HttpContextInterface
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var bool
     */
    protected $isTerminated;

    /**
     * HttpContext constructor.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $errors
     * @param bool $isTerminated
     */
    public function __construct(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $errors = [],
        bool $isTerminated = false
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->errors = $errors;
        $this->isTerminated = $isTerminated;
    }

    public function getRequest() : ServerRequestInterface
    {
        return $this->request;
    }

    public function withRequest(ServerRequestInterface $request): HttpContextInterface
    {
        return new static(
            $request,
            $this->response,
            $this->errors,
            $this->isTerminated
        );
    }

    public function getResponse() : ResponseInterface
    {
        return $this->response;
    }

    public function withResponse(ResponseInterface $response): HttpContextInterface
    {
        return new static(
            $this->request,
            $response,
            $this->errors,
            $this->isTerminated
        );
    }

    public function isTerminated(): bool
    {
        return $this->isTerminated;
    }

    public function withIsTerminated(bool $isTerminated): HttpContextInterface
    {
        return new static(
            $this->request,
            $this->response,
            $this->errors,
            $isTerminated
        );
    }

    public function handledBy(HttpHandlerInterface $handler): HttpContextInterface
    {
        return $handler($this);
    }

}