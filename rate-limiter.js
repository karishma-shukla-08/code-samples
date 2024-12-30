/**
 * Creates a rate limiter function to allow a maximum number of requests within a given time frame.
 * 
 * @param {number} maxRequests - The maximum number of requests allowed.
 * @param {number} timeWindow - The time window in milliseconds.
 * @returns {Function} - A function to track requests. Returns true if allowed, false otherwise.
 * 
 * Example usage:
 * const rateLimiter = createRateLimiter(5, 10000);
 * console.log(rateLimiter('user1')); // Output: true
 * console.log(rateLimiter('user1')); // Output: true (up to 5 times within 10 seconds)
 */
 function createRateLimiter(maxRequests, timeWindow) {
    if (typeof maxRequests !== 'number' || maxRequests <= 0) {
        throw new Error('Invalid input: maxRequests must be a positive number.');
    }
    if (typeof timeWindow !== 'number' || timeWindow <= 0) {
        throw new Error('Invalid input: timeWindow must be a positive number.');
    }

    const requestLog = new Map();

    return function (userId) {
        const now = Date.now();
        if (!requestLog.has(userId)) {
            requestLog.set(userId, []);
        }

        const timestamps = requestLog.get(userId).filter(timestamp => now - timestamp < timeWindow);
        timestamps.push(now);
        requestLog.set(userId, timestamps);

        return timestamps.length <= maxRequests;
    };
}
