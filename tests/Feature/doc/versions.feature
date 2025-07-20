Feature: GET /v1/doc/versions
    Background:
        Given empty database
        And request is json
        And request uri is "/v1/doc/versions"

    Scenario: No versions
        When I send request
        Then response is not found
        And response is json
        And response matches the schema file "../error.v1.json"

    Scenario: Only hidden version
        Given hidden version "master"
        When I send request
        Then response is not found
        And response is json
        And response matches the schema file "../error.v1.json"

    Scenario: With deprecated version
        Given deprecated version "master"
        When I send request
        Then response is successful
        And response is json
        And response matches the schema file "versions.json"
        And dump response body
