@regression
Feature: Get a place from Sonar using UUID
  In order to get a place
  As a sonar user
  I need to provide UUID

  @sanity
  Scenario Outline: Get a registered place in Sonar using UUID
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    Then response code is "200"
    And I save UUID
    Given provider name is <SONAR_ID>
    When I send request using "GET" method
    Then response code is "200"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        | SONAR_ID |
      | facebook      | 96980666115              | sonar    |
      | foursquare    | 4a72174bf964a52055da1fe3 | sonar    |

  Scenario Outline: Get a registered place in Sonar using UUID and validate data from place
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    Then response code is "200"
    And I save UUID
    Given provider name is <SONAR_ID>
    When I send request using "GET" method
    Then response code is "200"
    And JSON contains the following key value data:
      | name | Anthropologie                                                   |
      | url  | https://foursquare.com/v/anthropologie/4a72174bf964a52055da1fe3 |


    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        | SONAR_ID |
      | foursquare    | 4a72174bf964a52055da1fe3 | sonar    |


  Scenario Outline: Get a registered place in Sonar using empty UUID
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    Then response code is "200"
    Given provider name is <SONAR_ID>
    When I send request using "GET" method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        | SONAR_ID |
      | facebook      | 96980666115              | sonar    |
      | foursquare    | 4a72174bf964a52055da1fe3 | sonar    |