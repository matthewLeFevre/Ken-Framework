<?php
class KenTests extends \PHPUnit\Framework\TestCase
{
  public function testTokenValidation()
  {
    $app = new \KenFramework\ken(['tokenValidation' => true]);
    $this->assertTrue($app->getTokenValidation(), "The app is not using token validation");
  }

  public function testParametersAreExtracted()
  {
    $routePaths = [
      '/users/:id/:date/times',
      '/accounts/admins',
      '/api/v1.0/documents/:id'
    ];

    foreach ($routePaths as $index => $route) {
      if ($index == 0) {
        $this->assertEquals(
          \KenFramework\Ken::extractParams($route),
          ['users', ':id', ':date', 'times']
        );
      }
      if ($index == 1) {
        $this->assertEquals(
          \KenFramework\Ken::extractParams($route),
          ['accounts', 'admins']
        );
      }
      if ($index == 2) {
        $this->assertEquals(
          \KenFramework\Ken::extractParams($route),
          ['api', 'v1.0', 'documents', ':id']
        );
      }
    }
  }

  public function testBindingRequestParametersWithEndpointRoutes()
  {
    $request = new \KenFramework\Request('GET', '/accounts/12/fifty', null, null, null, null);
    $endpoint = new \KenFramework\Route('GET', '/accounts/:id/:num', function () {
    });

    $this->assertEquals(\KenFramework\Ken::bindParams($request, $endpoint), ['id' => 12, 'num' => 'fifty']);
  }
}
