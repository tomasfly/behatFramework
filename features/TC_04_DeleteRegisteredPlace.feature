@regression
Feature: Delete a place from Sonar
  In order to delete a place
  As a sonar user
  I need to provide PROVIDER_NAME and PROVIDER_PLACE_ID

  @scenario11
  Scenario Outline: Delete a registered place and all its associations using empty place id
    Given provider name is <PROVIDER_NAME>
    When I send request using "DELETE" method
    Then response code is "404"
    Examples:
      | PROVIDER_NAME |
      | wrongvalue1   |
      | wrongvalue2   |

  @scenario12
  Scenario Outline: Delete a registered place and all its associations using wrong provider name
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "DELETE" method
    Then response code is "404"
    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | wrongvalue1   | 96980666115              |
      | wrongvalue2   | 4a72174bf964a52055da1fe3 |

  @sanity
  @scenario13
  @deleteplace
  @addPlaces
  Scenario Outline: Delete a registered place and all its associations and then check that it has been deleted correctly.
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "DELETE" method
    Then response code is "200"
    And I send request using "GET" method
    And wait a few seconds
    And response code is "404"
    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | facebook      | 96980666115              |
      | foursquare    | 4a72174bf964a52055da1fe3 |