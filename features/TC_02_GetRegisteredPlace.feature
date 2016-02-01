Feature: Add new place in sonar
  In order to add a new place in sonar
  As a sonar user
  I need to provide PROVIDER_NAME and PROVIDER_PLACE_ID

  Scenario Outline: Get a registered place from the provider's information
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using GET method
    Then response code is "200"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | facebook      | 96980666115              |
      | foursquare    | 4a72174bf964a52055da1fe3 |

  Scenario Outline: Get a registered place from the provider's information and verify that response contains expected data
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using GET method
    Then response code is "200"
    Then JSON contains the following data:
      | provider_id   |
      | provider_name |
      | provider_hash |
      | name          |
      | url           |

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | facebook      | 96980666115              |
      | foursquare    | 4a72174bf964a52055da1fe3 |


  Scenario Outline: Get a registered place from the provider's information and verify that provider id and provider name values are expected
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using GET method
    Then response code is "200"
    And JSON contains the following key value data:
      | provider_id   | <PROVIDER_PLACE_ID> |
      | provider_name | <PROVIDER_NAME>     |


    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | facebook      | 96980666115              |
      | foursquare    | 4a72174bf964a52055da1fe3 |

  Scenario Outline: Get a registered place from the provider's information using wrong provider name
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using GET method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | wrongvalue1   | 96980666115              |
      | wrongvalue2   | 4a72174bf964a52055da1fe3 |

  Scenario Outline: Get a registered place from the provider's information using wrong provider place id
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using GET method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | facebook      | 00000000000              |
      | foursquare    | 000000000000000000000000 |

  @test
  Scenario Outline: Get a registered place from the provider's information using empty place id
    Given provider name is <PROVIDER_NAME>
    When I send request using GET method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME |
      | facebook      |
      | foursquare    |

