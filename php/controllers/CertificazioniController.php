<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CertificazioniController
{
    public function index(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $id = $args['id'];
        $results = $mysqli_connection->query("SELECT * FROM certificazioni WHERE alunno_id = '$id'");
        $results = $results->fetch_all(MYSQLI_ASSOC);
        if(count(($results)) > 0){
          $response->getBody()->write(json_encode($results));
          return $response->withHeader("Content-type", "application/json")->withStatus(200);
        }
        return $response->withHeader("Content-length", "0")->withStatus(404);
      }
    
      public function show(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $results = $mysqli_connection->query("SELECT certificazioni.* FROM alunni JOIN certificazioni ON (certificazioni.alunno_id = alunni.id) WHERE alunni.id = " . $args['id']. " AND certificazioni.alunno_id  = " . $args['id_cert']. "");
        $results = $results->fetch_all(MYSQLI_ASSOC);
        if(count(($results)) > 0){
          $response->getBody()->write(json_encode($results));
          return $response->withHeader("Content-type", "application/json")->withStatus(200);
        }
        return $response->withHeader("Content-length", "0")->withStatus(404);
      }
    
      public function search(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        
        $result = $mysqli_connection->query("SELECT * FROM alunni WHERE cognome LIKE '%" . $args['surname']. "%'");
        if($result->num_rows > 0){
          $results = $result->fetch_all(MYSQLI_ASSOC);
          $response->getBody()->write(json_encode($results));
          return $response->withHeader("Content-type", "application/json")->withStatus(200);
        }
        return $response->withHeader("Content-length", "0")->withStatus(404);
      }
      public function showOrdered(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');   
    
        $result = $mysqli_connection->query("SELECT * FROM alunni WHERE cognome LIKE '%" . $args['surname']. "%'");
        if($result->num_rows > 0){
          $results = $result->fetch_all(MYSQLI_ASSOC);
          $response->getBody()->write(json_encode($results));
          return $response->withHeader("Content-type", "application/json")->withStatus(200);
        }
        return $response->withHeader("Content-length", "0")->withStatus(404);
      }
    
      public function create(Request $request, Response $response, $args){
        $body = json_decode($request->getbody()->getContents(), true);
        $nome = $body["nome"];
        $cognome = $body["cognome"];
    
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        if($mysqli_connection->query("INSERT INTO alunni (nome, cognome) VALUES ('$nome', '$cognome')")){
          return $response->withHeader("Content-Length", "0")->withStatus(204);
        }
        return $response->withHeader("Content-length", "0")->withStatus(400);
        
      
      }
    
      public function update(Request $request, Response $response, $args){
        $body = json_decode($request->getbody()->getContents(), true);
        $nome = $body["nome"];
        $cognome = $body["cognome"];
    
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        if($mysqli_connection->query($mysqli_connection->query("UPDATE alunni SET nome = '$nome', cognome = '$cognome' WHERE id = " . $args['id']. ""))){
          return $response->withHeader("Content-type", "application/json")->withStatus(204);
        }
        return $response->withHeader("Content-length", "0")->withStatus(400);
      }
      public function destroy(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        if($mysqli_connection->query("DELETE FROM alunni WHERE id = " . $args['id']. "")){
          return $response->withHeader("Content-Length", "0")->withStatus(200);
        }
        return $response->withHeader("Content-length", "0")->withStatus(400);
      }
}
