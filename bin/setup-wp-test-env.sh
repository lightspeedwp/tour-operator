#!/bin/bash

# Quick WordPress Test Environment Setup Script

echo "Setting up WordPress test environment variables..."

export WP_TESTS_DIR='/tmp/wordpress-tests-lib'
export WP_CORE_DIR='/tmp/wordpress/'
export WP_TESTS_DB_NAME='tour_operator_test'
export WP_TESTS_DB_USER='root'
export WP_TESTS_DB_PASSWORD=''
export WP_TESTS_DB_HOST='localhost'

echo "Environment variables set!"
echo ""
echo "WP_TESTS_DIR: $WP_TESTS_DIR"
echo "WP_CORE_DIR: $WP_CORE_DIR"
echo "WP_TESTS_DB_NAME: $WP_TESTS_DB_NAME"
echo ""
echo "Now you can run:"
echo "  composer test:wp    # WordPress integration tests"
echo "  composer test       # Simple PHP tests"
echo "  npm test            # All tests (PHP + E2E)"
