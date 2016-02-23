@regression
@tc_01_AddNewPlaceInSonar
Feature: Add a new place to Sonar
  In order to add a new place in sonar
  As a sonar user
  I need to provide PROVIDER_NAME and PROVIDER_PLACE_ID

  @sanity
  @scenario1
  @deleteplace
  Scenario Outline: Add a registered place from the provider's information and verify response data
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    Then response code is "201"
    And JSON contains the following data:
      | id                 |
      | name               |
      | url                |
      | source             |
      | geopoint           |
      | instagram_location |
    And response contains the following source information
      | provider_name | <PROVIDER_NAME> |
      | name          | <PLACE_NAME>    |
      | url           | <URL>           |
    And I send request using "PUT" method
    Then response code is "200"
    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        | PLACE_NAME                     | URL                                                             |
      | facebook      | 96980666115              | Omni Barton Creek Resort & Spa | https://www.facebook.com/OmniBartonCreek/                       |
      | foursquare    | 4a72174bf964a52055da1fe3 | Anthropologie                  | https://foursquare.com/v/anthropologie/4a72174bf964a52055da1fe3 |

  @scenario2
  Scenario Outline: Add a registered place from the provider's information using wrong provider place id
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | facebook      | 96980660000              |
      | foursquare    | 4a72174bf964a52000000000 |

  @scenario3
  Scenario Outline: Add a registered place from the provider's information using wrong provider name
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "PUT" method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | wrongvalue1   | 96980666115              |
      | wrongvalue2   | 4a72174bf964a52055da1fe3 |

  @scenario4
  Scenario Outline: Add a registered place from the provider's information using empty place id
    Given provider name is <PROVIDER_NAME>
    When I send request using "PUT" method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME |
      | facebook      |
      | foursquare    |