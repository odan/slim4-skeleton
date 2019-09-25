const path = require('path');

module.exports = {
    verbose: true,
    testMatch: ['**/(*.)test.js'],
    moduleFileExtensions: ['js', 'json'],
    coverageDirectory: './build/tests/unit/coverage',
    coverageReporters: ['json', 'html'],
    roots: [
        "<rootDir>/tests/Frontend"
    ],
    testPathIgnorePatterns: ['/node_modules/'],
    "setupFiles": ["./tests/Jest/setup-jest.js"],
    "moduleNameMapper": {
        "\\.(css|less)$": "identity-obj-proxy"
    }
}
