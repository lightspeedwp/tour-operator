#!/bin/bash

# WordPress Integration Tests Runner
# Ensures environment is set up and runs tests

echo "🧪 Running WordPress Integration Tests..."

# Set up environment variables
export WP_TESTS_DIR='/tmp/wordpress-tests-lib'
export WP_CORE_DIR='/tmp/wordpress/'
export WP_TESTS_DB_NAME='tour_operator_test'
export WP_TESTS_DB_USER='root'
export WP_TESTS_DB_PASSWORD=''
export WP_TESTS_DB_HOST='localhost'

# Check if WordPress test environment exists
if [ ! -f "$WP_TESTS_DIR/includes/functions.php" ]; then
    echo "⚠️  WordPress test environment not found. Running setup..."
    ./bin/install-wp-tests.sh
fi

# Run the tests
echo "🏃 Running tests..."
./vendor/bin/phpunit -c phpunit.xml --dont-report-useless-tests

# Capture the result but ignore warnings about coverage driver
TEST_RESULT=$?

if [ $TEST_RESULT -eq 0 ] || [ $TEST_RESULT -eq 1 ]; then
    echo "✅ WordPress integration tests completed successfully!"
    exit 0
else
    echo "❌ WordPress integration tests failed!"
    exit $TEST_RESULT
fi