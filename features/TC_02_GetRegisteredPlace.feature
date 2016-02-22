@regression
Feature: Get a place from Sonar
  In order to get a place
  As a sonar user
  I need to provide PROVIDER_NAME and PROVIDER_PLACE_ID

  @scenario5
  @sanity
  @deleteplace
  @addPlaces
  Scenario Outline: Get a registered place from the provider's information and verify that response data is correct
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "GET" method
    Then response code is "200"
    And JSON contains the following key value data:
      | provider_id   | <PROVIDER_PLACE_ID> |
      | provider_name | <PROVIDER_NAME>     |
      | name          | <NAME>              |
      | url           | <URL>               |
    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        | NAME                           | URL                                                             |
      | facebook      | 96980666115              | Omni Barton Creek Resort & Spa | https://www.facebook.com/OmniBartonCreek/                       |
      | foursquare    | 4a72174bf964a52055da1fe3 | Anthropologie                  | https://foursquare.com/v/anthropologie/4a72174bf964a52055da1fe3 |

  @scenario6
  Scenario Outline: Get a registered place from the provider's information using wrong provider name
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "GET" method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | wrongvalue1   | 96980666115              |
      | wrongvalue2   | 4a72174bf964a52055da1fe3 |

  @scenario7
  Scenario Outline: Get a registered place from the provider's information using wrong provider place id
    Given provider name is <PROVIDER_NAME>
    And provider place id is <PROVIDER_PLACE_ID>
    When I send request using "GET" method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME | PROVIDER_PLACE_ID        |
      | facebook      | 00000000000              |
      | foursquare    | 000000000000000000000000 |

  @scenario8
  Scenario Outline: Get a registered place from the provider's information using empty place id
    Given provider name is <PROVIDER_NAME>
    When I send request using "GET" method
    Then response code is "404"

    Examples:
      | PROVIDER_NAME |
      | facebook      |
      | foursquare    |