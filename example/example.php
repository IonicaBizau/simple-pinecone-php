<?php
  require "pinecone.php";

  $pinecone = new Pinecone(PINECONE_API_KEY, PINECONE_HOST);
  $indexes = $pinecone->getRequest("https://api.pinecone.io/indexes");

  header("Content-Type: application/json");

  // List the vector IDs
  $vectorIds = $pinecone->getRequest("/vectors/list", [
    "namespace" => "example-namespace"
  ]);
  echo json_encode($vectorIds);

  // Upsert vector
  $text = "Hello World";

  // Define the function to compute the embedding (via OpenAI etc)
  $embedding = getEmbedding($text);
  $vector = [
      'id' => md5($text),
      'values' => $embedding,
      'metadata' => [
          'title' => "Example"
      ]
  ];

  // Upsert the vector
  $res = $pinecone->postRequest("/vectors/upsert", [
      "vectors" => [$vector]
  ]);

