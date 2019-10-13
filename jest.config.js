const path = require('path');
const {defaults} = require('jest-config');

module.exports = {
    verbose: true,
    testMatch: ['**/(*.)test.js'],
    moduleFileExtensions: [...defaults.moduleFileExtensions, 'ts', 'tsx'],
    coverageDirectory: './build/tests/unit/coverage',
    coverageReporters: ['json', 'html'],
    roots: [
        "<rootDir>/tests/Frontend"
    ],
    testPathIgnorePatterns: ['/node_modules/'],
    setupFiles: ["./tests/setup-jest.js"],
    moduleNameMapper: {
        "\\.(css|less)$": "identity-obj-proxy"
    },
    transform: {
        "^.+\\.tsx?$": "ts-jest"
    },
}
