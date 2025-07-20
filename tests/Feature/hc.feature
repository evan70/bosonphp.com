Feature: POST /v1/hc
    Background:
        Given empty database

    Scenario: example
        When I send request
        Then response status is 42
