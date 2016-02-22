@regression
Feature: Get a place from Sonar using UUID
  In order to get a place
  As a sonar user
  I need to provide UUID

  @scenario9
  @sanity
  @deleteplace
  Scenario Outline: Get a registered place in Sonar using UUID
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    And response code is "201"
    And I save UUID
    And provider name is <SONAR_ID>
    And I send request using "GET" method
    Then response code is "200"
    And JSON contains the following key value data:
      | name | <NAME> |
      | url  | <URL>  |
    And response contains the following source information
      | provider_name | <PROVIDER_NAME> |
      | name          | <NAME>          |
      | url           | <URL>           |
    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        | NAME                           | URL                                                             | SONAR_ID |
      | facebook      | 96980666115              | Omni Barton Creek Resort & Spa | https://www.facebook.com/OmniBartonCreek/                       | sonar    |
      | foursquare    | 4a72174bf964a52055da1fe3 | Anthropologie                  | https://foursquare.com/v/anthropologie/4a72174bf964a52055da1fe3 | sonar    |

  @scenario10
  @deleteplace
  Scenario Outline: Get a registered place in Sonar using empty UUID
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    Then response code is "201"
    Given provider name is <SONAR_ID>
    When I send request using "GET" method
    Then response code is "404"
    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        | SONAR_ID |
      | facebook      | 96980666115              | sonar    |
      | foursquare    | 4a72174bf964a52055da1fe3 | sonar    |