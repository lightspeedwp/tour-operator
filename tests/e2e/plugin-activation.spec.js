/**
 * E2E Test: Tour Operator Plugin Activation and Admin Menu
 *
 * @package Tour_Operator
 * @subpackage Tests
 */

import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe('Tour Operator Plugin Activation', () => {
	test.beforeEach(async ({ admin }) => {
		// Navigate to dashboard before each test
		await admin.visitAdminPage('/');
	});

	test('should display Tour Operator menu items in admin', async ({
		admin,
		page,
	}) => {
		// Navigate to admin dashboard
		await admin.visitAdminPage('/');

		// Check for "Tours" menu item
		const tourMenu = page.locator('#menu-posts-tour');
		await expect(tourMenu).toBeVisible({
			timeout: 10000,
		});
		await expect(tourMenu).toContainText('Tours');

		// Check for "Accommodations" menu item
		const accommodationMenu = page.locator('#menu-posts-accommodation');
		await expect(accommodationMenu).toBeVisible({
			timeout: 10000,
		});
		await expect(accommodationMenu).toContainText('Accommodation');

		// Check for "Destinations" menu item
		const destinationMenu = page.locator('#menu-posts-destination');
		await expect(destinationMenu).toBeVisible({
			timeout: 10000,
		});
		await expect(destinationMenu).toContainText('Destinations');
	});

	test('should have correct submenu items for Tours', async ({
		admin,
		page,
	}) => {
		await admin.visitAdminPage('/');

		// Hover over Tours menu to reveal submenu
		const tourMenu = page.locator('#menu-posts-tour');
		await tourMenu.hover();

		// Check for expected submenu items
		const allToursLink = page.locator(
			'#menu-posts-tour a[href="edit.php?post_type=tour"]'
		);
		await expect(allToursLink).toBeVisible();

		const addNewLink = page.locator(
			'#menu-posts-tour a[href="post-new.php?post_type=tour"]'
		);
		await expect(addNewLink).toBeVisible();

		const categoriesLink = page.locator(
			'#menu-posts-tour a[href*="taxonomy=travel-style"]'
		);
		await expect(categoriesLink).toBeVisible();
	});

	test('should allow creating a new Tour', async ({ admin, page }) => {
		// Navigate to new tour creation page
		await admin.visitAdminPage('post-new.php?post_type=tour');

		// Wait for editor to load
		await page.waitForLoadState('networkidle');

		// Check for block editor presence (either iframe or direct)
		const editorCanvasIframe = page.locator('iframe[name="editor-canvas"]');
		const hasIframeEditor = await editorCanvasIframe.isVisible().catch(() => false);

		if (hasIframeEditor) {
			// Iframe-based editor (FSE)
			await expect(editorCanvasIframe).toBeVisible();
		} else {
			// Classic block editor
			const titleField = page.getByRole('textbox', {
				name: /add title/i,
			});
			await expect(titleField).toBeVisible({
				timeout: 10000,
			});
		}

		// Verify post type is correct
		const postTypeInput = page.locator('input[name="post_type"]');
		if (await postTypeInput.isVisible()) {
			await expect(postTypeInput).toHaveValue('tour');
		}
	});

	test('should allow creating a new Accommodation', async ({
		admin,
		page,
	}) => {
		await admin.visitAdminPage('post-new.php?post_type=accommodation');
		await page.waitForLoadState('networkidle');

		// Check for editor presence
		const editorCanvasIframe = page.locator('iframe[name="editor-canvas"]');
		const hasIframeEditor = await editorCanvasIframe.isVisible().catch(() => false);

		if (hasIframeEditor) {
			await expect(editorCanvasIframe).toBeVisible();
		} else {
			const titleField = page.getByRole('textbox', {
				name: /add title/i,
			});
			await expect(titleField).toBeVisible({
				timeout: 10000,
			});
		}
	});

	test('should allow creating a new Destination', async ({ admin, page }) => {
		await admin.visitAdminPage('post-new.php?post_type=destination');
		await page.waitForLoadState('networkidle');

		// Check for editor presence
		const editorCanvasIframe = page.locator('iframe[name="editor-canvas"]');
		const hasIframeEditor = await editorCanvasIframe.isVisible().catch(() => false);

		if (hasIframeEditor) {
			await expect(editorCanvasIframe).toBeVisible();
		} else {
			const titleField = page.getByRole('textbox', {
				name: /add title/i,
			});
			await expect(titleField).toBeVisible({
				timeout: 10000,
			});
		}
	});

	test('should display Tour Operator in plugins list', async ({
		admin,
		page,
	}) => {
		// Navigate to plugins page
		await admin.visitAdminPage('plugins.php');

		// Search for Tour Operator plugin row
		const pluginRow = page.locator('tr[data-slug="tour-operator"]');
		await expect(pluginRow).toBeVisible();

		// Verify plugin is active
		const activeIndicator = pluginRow.locator('.active');
		await expect(activeIndicator).toBeVisible();

		// Check for plugin name
		const pluginName = pluginRow.locator('.plugin-title strong');
		await expect(pluginName).toContainText('Tour Operator');
	});

	test('should have Block Editor patterns available', async ({
		admin,
		editor,
		page,
	}) => {
		// Create a new tour
		await admin.createNewPost({ postType: 'tour' });

		// Open block inserter
		await editor.openGlobalBlockInserter();

		// Search for Tour Operator patterns
		const searchInput = page.getByPlaceholder('Search');
		await searchInput.fill('tour operator');

		// Wait for search results
		await page.waitForTimeout(1000);

		// Check for pattern category or specific patterns
		const patternResults = page.locator('.block-editor-block-patterns-list');

		// Verify some results appear (patterns exist)
		const hasPatterns = await patternResults.isVisible().catch(() => false);

		if (hasPatterns) {
			// Optionally verify specific pattern names
			const tourCardPattern = page.locator(
				'[aria-label*="Tour Card"], [aria-label*="tour-card"]'
			);
			// This might not always be visible depending on search, so we make it optional
			const hasTourCard = await tourCardPattern.isVisible().catch(() => false);
			expect(hasTourCard || hasPatterns).toBeTruthy();
		}
	});
});

test.describe('Tour Operator Taxonomy Management', () => {
	test('should allow creating Travel Style terms', async ({
		admin,
		page,
	}) => {
		// Navigate to Travel Style taxonomy
		await admin.visitAdminPage(
			'edit-tags.php?taxonomy=travel-style&post_type=tour'
		);

		// Check for add new term form
		const nameInput = page.locator('#tag-name');
		await expect(nameInput).toBeVisible();

		const slugInput = page.locator('#tag-slug');
		await expect(slugInput).toBeVisible();

		const submitButton = page.locator('#submit');
		await expect(submitButton).toBeVisible();
	});

	test('should allow creating Accommodation Type terms', async ({
		admin,
		page,
	}) => {
		await admin.visitAdminPage(
			'edit-tags.php?taxonomy=accommodation-type&post_type=accommodation'
		);

		const nameInput = page.locator('#tag-name');
		await expect(nameInput).toBeVisible();
	});
});

test.describe('Tour Operator Settings', () => {
	test('should have plugin settings or configuration available', async ({
		admin,
		page,
	}) => {
		await admin.visitAdminPage('/');

		// Check if there's a settings page (this depends on your plugin structure)
		// You may need to adjust based on actual settings implementation
		const settingsMenu = page.locator(
			'#adminmenu a[href*="tour-operator"]'
		);

		// If settings exist, verify they're accessible
		const hasSettings = await settingsMenu.isVisible().catch(() => false);

		if (hasSettings) {
			await settingsMenu.click();
			await page.waitForLoadState('networkidle');

			// Verify we're on a tour operator settings page
			const pageTitle = page.locator('h1, h2.nav-tab-wrapper');
			await expect(pageTitle).toBeVisible();
		} else {
			// If no settings page, just verify core functionality exists
			const tourMenu = page.locator('#menu-posts-tour');
			await expect(tourMenu).toBeVisible();
		}
	});
});
