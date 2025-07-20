Feature: GET /v1/doc/versions
    Background:
        Given empty database
        And request is json
        And request uri is "/v1/doc/versions"

    Scenario: No versions
        When I send request
        Then response is not found

    Scenario: Only hidden version
        Given hidden version "master"
        When I send request
        Then response is not found

    Scenario: With deprecated version
        Given deprecated version "master"
        When I send request
        Then response is successful
        And dump response body
